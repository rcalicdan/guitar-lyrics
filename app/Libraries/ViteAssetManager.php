<?php

namespace App\Libraries;

class ViteAssetManager
{
    private static ?string $cachedBaseUrl = null;

    private string $devServerBaseUrl;

    private string $manifestPath;

    private string $distPath;

    public function __construct(
        ?string $devServerBaseUrl = null,
        ?string $manifestPath = null,
        string $distPath = 'dist'
    ) {
        $this->devServerBaseUrl = $devServerBaseUrl ?? env('VITE_DEV_SERVER', 'http://localhost:3000');
        $this->manifestPath = $manifestPath ?? FCPATH.'dist/.vite/manifest.json';
        $this->distPath = $distPath;
    }

    /**
     * Generate asset tags for given entrypoints
     */
    public function generateAssets($entrypoints, bool $includeViteClient = true): string
    {
        $startTime = microtime(true);

        $entrypoints = $this->normalizeEntrypoints($entrypoints);

        $result = ENVIRONMENT === 'development'
            ? $this->buildDevelopmentAssets($entrypoints, $includeViteClient)
            : $this->buildProductionAssets($entrypoints);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        if ($executionTime > 0.1) { // Log if takes more than 100ms
            log_message('debug', sprintf(
                'ViteAssetManager: Total execution time=%.3fs for %d entrypoints',
                $executionTime,
                count($entrypoints)
            ));
        }

        return $result;
    }

    /**
     * Build assets for development environment
     */
    private function buildDevelopmentAssets(array $entrypoints, bool $includeViteClient): string
    {
        $output = '';

        if ($includeViteClient) {
            $output .= $this->createViteClientScript();
        }

        foreach ($entrypoints as $entry) {
            $output .= $this->createDevelopmentAssetTag($entry);
        }

        return $output;
    }

    /**
     * Build assets for production environment (optimized)
     */
    private function buildProductionAssets(array $entrypoints): string
    {
        $manifest = $this->getManifest();

        if ($manifest === null) {
            return $this->createErrorComment('Vite Manifest Could Not Be Loaded');
        }

        // Collect all assets first to avoid duplicates and reduce processing
        $stylesheets = [];
        $scripts = [];
        $preloads = [];

        foreach ($entrypoints as $entry) {
            if (! isset($manifest[$entry])) {
                $this->logWarning("Vite entry point '{$entry}' not found in manifest.");

                continue;
            }

            $manifestEntry = $manifest[$entry];

            if ($this->isCssFile($manifestEntry['file'])) {
                $stylesheets[] = $manifestEntry['file'];
            } else {
                // Add CSS files associated with this JS entry
                if (! empty($manifestEntry['css'])) {
                    $stylesheets = array_merge($stylesheets, $manifestEntry['css']);
                }

                // Add the main script
                $scripts[] = $manifestEntry['file'];

                // Add imports for preloading
                if (! empty($manifestEntry['imports'])) {
                    foreach ($manifestEntry['imports'] as $importName) {
                        if (isset($manifest[$importName]['file'])) {
                            $preloads[] = $manifest[$importName]['file'];
                        }
                    }
                }
            }
        }

        // Generate all tags at once (more efficient)
        return $this->generateAssetTags($stylesheets, $scripts, $preloads);
    }

    /**
     * Generate all asset tags efficiently
     */
    private function generateAssetTags(array $stylesheets, array $scripts, array $preloads): string
    {
        $baseUrl = $this->getBaseUrl();
        $distPath = $this->distPath;
        $output = '';

        // Remove duplicates and generate stylesheet tags
        foreach (array_unique($stylesheets) as $css) {
            $output .= "<link rel=\"stylesheet\" href=\"{$baseUrl}/{$distPath}/{$css}\">\n";
        }

        // Generate script tags
        foreach (array_unique($scripts) as $script) {
            $output .= "<script type=\"module\" src=\"{$baseUrl}/{$distPath}/{$script}\"></script>\n";
        }

        // Generate preload tags
        foreach (array_unique($preloads) as $preload) {
            $output .= "<link rel=\"modulepreload\" href=\"{$baseUrl}/{$distPath}/{$preload}\">\n";
        }

        return $output;
    }

    /**
     * Get and cache the Vite manifest with proper caching
     */
    private function getManifest(): ?array
    {
        // Use CodeIgniter's cache system for persistent caching
        $cache = \Config\Services::cache();
        $cacheKey = 'vite_manifest_'.md5($this->manifestPath);

        // Try to get from cache first
        $manifest = $cache->get($cacheKey);
        if ($manifest !== null) {
            return $manifest;
        }

        // Check if manifest file exists
        if (! file_exists($this->manifestPath)) {
            $this->logError("Vite manifest not found at: {$this->manifestPath}");
            // Cache the null result for a short time to avoid repeated file checks
            $cache->save($cacheKey, null, 60);

            return null;
        }

        // Read and parse manifest
        $manifestContent = file_get_contents($this->manifestPath);
        if ($manifestContent === false) {
            $this->logError("Could not read Vite manifest at: {$this->manifestPath}");
            $cache->save($cacheKey, null, 60);

            return null;
        }

        $manifest = json_decode($manifestContent, true);

        if ($manifest === null) {
            $this->logError('Vite manifest could not be parsed: '.json_last_error_msg());
            $cache->save($cacheKey, null, 60);

            return null;
        }

        // Cache the manifest for 1 hour in production, 5 minutes in development
        $cacheTime = ENVIRONMENT === 'production' ? 3600 : 300;
        $cache->save($cacheKey, $manifest, $cacheTime);

        return $manifest;
    }

    /**
     * Get cached base URL to avoid repeated calls
     */
    private function getBaseUrl(): string
    {
        if (self::$cachedBaseUrl === null) {
            self::$cachedBaseUrl = rtrim(base_url(), '/');
        }

        return self::$cachedBaseUrl;
    }

    /**
     * Create HTML tags (optimized versions)
     */
    private function createViteClientScript(): string
    {
        return "<script type=\"module\" src=\"{$this->devServerBaseUrl}/@vite/client\"></script>\n";
    }

    private function createDevelopmentAssetTag(string $entry): string
    {
        $url = "{$this->devServerBaseUrl}/{$entry}";

        return $this->isCssFile($entry)
            ? "<link rel=\"stylesheet\" href=\"{$url}\">\n"
            : "<script type=\"module\" src=\"{$url}\"></script>\n";
    }

    private function createErrorComment(string $message): string
    {
        return "<!-- {$message} -->\n";
    }

    /**
     * Utility methods
     */
    private function normalizeEntrypoints($entrypoints): array
    {
        return is_array($entrypoints) ? $entrypoints : [$entrypoints];
    }

    private function isCssFile(string $filename): bool
    {
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION)) === 'css';
    }

    private function logError(string $message): void
    {
        log_message('error', $message);
    }

    private function logWarning(string $message): void
    {
        log_message('warning', $message);
    }

    /**
     * Static method for global configuration
     */
    public static function configure(array $config = []): self
    {
        return new self(
            $config['devServerBaseUrl'] ?? null,
            $config['manifestPath'] ?? null,
            $config['distPath'] ?? 'dist'
        );
    }

    /**
     * Clear the manifest cache (useful for deployment)
     */
    public static function clearCache(): bool
    {
        $cache = \Config\Services::cache();

        return $cache->deleteMatching('vite_manifest_*');
    }
}
