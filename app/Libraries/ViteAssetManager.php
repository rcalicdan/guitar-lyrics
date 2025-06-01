<?php

namespace App\Libraries;

class ViteAssetManager
{
    private static ?array $manifest = null;
    private string $devServerBaseUrl;
    private string $manifestPath;
    private string $distPath;

    public function __construct(
        ?string $devServerBaseUrl = null,
        ?string $manifestPath = null,
        string $distPath = 'dist'
    ) {
        $this->devServerBaseUrl = $devServerBaseUrl ?? env('VITE_DEV_SERVER', 'http://localhost:3000');
        $this->manifestPath = $manifestPath ?? FCPATH . 'dist/.vite/manifest.json'; 
        $this->distPath = $distPath;
    }

    /**
     * Generate asset tags for given entrypoints
     */
    public function generateAssets($entrypoints, bool $includeViteClient = true): string
    {
        $entrypoints = $this->normalizeEntrypoints($entrypoints);

        return ENVIRONMENT === 'development'
            ? $this->buildDevelopmentAssets($entrypoints, $includeViteClient)
            : $this->buildProductionAssets($entrypoints);
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
     * Build assets for production environment
     */
    private function buildProductionAssets(array $entrypoints): string
    {
        $manifest = $this->getManifest();

        if ($manifest === null) {
            return $this->createErrorComment('Vite Manifest Could Not Be Loaded');
        }

        $output = '';
        foreach ($entrypoints as $entry) {
            $output .= $this->processManifestEntry($entry, $manifest);
        }

        return $output;
    }

    /**
     * Process a single manifest entry
     */
    private function processManifestEntry(string $entry, array $manifest): string
    {
        if (!isset($manifest[$entry])) {
            $this->logWarning("Vite entry point '{$entry}' not found in manifest.");
            return $this->createErrorComment("Vite Entry Point '{$entry}' Not Found in Manifest");
        }

        $manifestEntry = $manifest[$entry];

        if ($this->isCssFile($manifestEntry['file'])) {
            return $this->createStylesheetTag($manifestEntry['file']);
        }

        return $this->buildJavaScriptEntry($manifestEntry, $manifest);
    }

    /**
     * Build JavaScript entry with associated CSS and imports
     */
    private function buildJavaScriptEntry(array $manifestEntry, array $manifest): string
    {
        $output = '';

        // Add associated CSS files
        if (!empty($manifestEntry['css'])) {
            foreach ($manifestEntry['css'] as $cssFile) {
                $output .= $this->createStylesheetTag($cssFile);
            }
        }

        // Add the main script
        $output .= $this->createScriptTag($manifestEntry['file']);

        // Add module preloads
        if (!empty($manifestEntry['imports'])) {
            $output .= $this->buildModulePreloads($manifestEntry['imports'], $manifest);
        }

        return $output;
    }

    /**
     * Build module preload tags
     */
    private function buildModulePreloads(array $imports, array $manifest): string
    {
        $output = '';

        foreach ($imports as $importName) {
            if (isset($manifest[$importName]['file'])) {
                $output .= $this->createModulePreloadTag($manifest[$importName]['file']);
            }
        }

        return $output;
    }

    /**
     * Get and cache the Vite manifest
     */
    private function getManifest(): ?array
    {
        if (self::$manifest !== null) {
            return self::$manifest;
        }

        if (!file_exists($this->manifestPath)) {
            $this->logError("Vite manifest not found at: {$this->manifestPath}");
            return null;
        }

        $manifestContent = file_get_contents($this->manifestPath);
        self::$manifest = json_decode($manifestContent, true);

        if (self::$manifest === null) {
            $this->logError("Vite manifest could not be parsed: " . json_last_error_msg());
            return null;
        }

        return self::$manifest;
    }

    /**
     * Create HTML tags
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

    private function createStylesheetTag(string $file): string
    {
        $url = base_url("{$this->distPath}/{$file}");
        return "<link rel=\"stylesheet\" href=\"{$url}\">\n";
    }

    private function createScriptTag(string $file): string
    {
        $url = base_url("{$this->distPath}/{$file}");
        return "<script type=\"module\" src=\"{$url}\"></script>\n";
    }

    private function createModulePreloadTag(string $file): string
    {
        $url = base_url("{$this->distPath}/{$file}");
        return "<link rel=\"modulepreload\" href=\"{$url}\">\n";
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
}
