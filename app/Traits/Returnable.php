<?php

namespace App\Traits;

use CodeIgniter\HTTP\URI; // Standard CodeIgniter URI class
use Config\App as AppConfig;
use Config\Services;

trait Returnable
{
    /**
     * Validates a given URL string or URI object to ensure it's safe for internal redirection.
     *
     * @param string|URI|null $urlToValidate    The URL (string or URI object) to check.
     * @param string          $defaultFallbackUrl The URL string to return if validation fails or input is empty.
     * @return string The sanitized, safe URL string for redirection.
     */
    private function sanitizeRedirectUrl($urlToValidate, string $defaultFallbackUrl): string
    {
        if (empty($urlToValidate)) {
            return $defaultFallbackUrl;
        }

        // 1. Determine the application's base characteristics (scheme, host, path)
        // We need a fully qualified base URI for the application to compare against.
        $config = config(AppConfig::class);
        $rawAppBaseUrl = $config->baseURL;
        $currentRequestUri = Services::request()->getUri(); // Get current request's URI

        $appBaseScheme = $currentRequestUri->getScheme();
        $appBaseHost = $currentRequestUri->getHost();
        $appBasePath = '/'; // Default to root path

        if (!empty($rawAppBaseUrl)) {
            try {
                // Attempt to parse baseURL as is, it might be fully qualified
                $tempAppBaseUri = new URI($rawAppBaseUrl);

                if (!empty($tempAppBaseUri->getScheme())) {
                    $appBaseScheme = $tempAppBaseUri->getScheme();
                }
                if (!empty($tempAppBaseUri->getHost())) {
                    $appBaseHost = $tempAppBaseUri->getHost();
                }
                // Path from baseURL needs careful handling
                $pathFromConfig = $tempAppBaseUri->getPath();
                if ($pathFromConfig !== '' && $pathFromConfig !== '/') {
                    // Normalize: ensure leading slash, remove trailing, then add one if not root
                    $appBasePath = '/' . trim($pathFromConfig, '/');
                    if ($appBasePath !== '/') { // Avoid // for root
                        $appBasePath .= '/';
                    }
                } elseif ($pathFromConfig === '/') {
                    $appBasePath = '/';
                }
                // Else, if pathFromConfig is empty but host/scheme were from baseURL, appBasePath remains '/'

            } catch (\Throwable $e) {
                // If baseURL is malformed, log it and rely on current request's host/scheme and root path
                log_message('error', "ReturnableTrait: Malformed App baseURL in config: '{$rawAppBaseUrl}'. Error: " . $e->getMessage());
            }
        }
        // Ensure appBasePath is clean (e.g. /subfolder/ or /)
        $appBasePath = preg_replace('#//+#', '/', $appBasePath);


        // 2. Parse the candidate URL for redirection
        try {
            $candidateUri = ($urlToValidate instanceof URI) ? $urlToValidate : new URI((string) $urlToValidate);
            $candidateUriString = (string) $candidateUri; // For logging or returning if valid
        } catch (\Throwable $e) {
            log_message('info', "ReturnableTrait: Invalid URL format for redirection candidate: " . (is_string($urlToValidate) ? $urlToValidate : 'URI Object') . ". Error: " . $e->getMessage());
            return $defaultFallbackUrl;
        }

        $candidateScheme = strtolower($candidateUri->getScheme());
        $candidateHost   = strtolower($candidateUri->getHost());
        // $candidateUri->getPath() returns a path where dot segments ('.', '..') have been processed by URI::filterPath
        $candidatePath   = $candidateUri->getPath();

        // Normalize candidatePath for comparison: start with a slash, clean multiple slashes.
        if ($candidatePath === '' || $candidatePath[0] !== '/') {
            $candidatePath = '/' . $candidatePath;
        }
        $candidatePath = preg_replace('#//+#', '/', $candidatePath);


        // CASE 1: Relative URI (parsed with no scheme and no host)
        // Examples: "/path/to/page", "path/page?query=1"
        if (empty($candidateScheme) && empty($candidateHost)) {
            // Check for protocol-relative URLs like "//otherdomain.com" passed as string,
            // which `new URI("//otherdomain.com")` would parse with "otherdomain.com" as host.
            // This `if` block is for true relative paths like "/foo" or "foo".
            // An initial string like "//..." would not land here if parsed correctly into host.
            // However, if $urlToValidate was like `javascript:`, scheme might be 'javascript'.
            // This check becomes more about ensuring it's a typical path.
            if (str_starts_with(trim($candidateUriString), '//')) {
                log_message('warning', "ReturnableTrait: Blocked relative-looking URI string that started with '//': " . $candidateUriString);
                return $defaultFallbackUrl;
            }
            // The path from $candidateUri->getPath() is already processed by URI::removeDotSegments.
            // A remaining '..' typically means an attempt to go above root of what was parsed, which filterPath should largely prevent.
            if (strpos($candidatePath, '..') !== false) {
                log_message('warning', "ReturnableTrait: Blocked relative redirect URL - path still contains '..' segments after URI parsing: '" . $candidateUriString . "' (Normalized path: '" . $candidatePath . "')");
                return $defaultFallbackUrl;
            }
            // If it's a valid-looking relative path, use site_url to construct full, safe URL.
            return site_url($candidateUriString);
        }

        // CASE 2: Absolute URI (parsed with scheme and host)
        if (!empty($candidateScheme) && !empty($candidateHost)) {
            // Security Check 2.1: Host must match the application's host.
            if ($candidateHost !== strtolower($appBaseHost)) {
                log_message('warning', "ReturnableTrait: Blocked redirect - host mismatch. Candidate: '{$candidateHost}', App: '{$appBaseHost}'. URL: '{$candidateUriString}'");
                return $defaultFallbackUrl;
            }

            // Security Check 2.2: Scheme must match the application's scheme.
            if ($candidateScheme !== strtolower($appBaseScheme)) {
                log_message('warning', "ReturnableTrait: Blocked redirect - scheme mismatch. Candidate: '{$candidateScheme}', App: '{$appBaseScheme}'. URL: '{$candidateUriString}'");
                return $defaultFallbackUrl;
            }

            // Security Check 2.3: Candidate path must be within the application's base path.
            // Example: $appBasePath = "/myapp/", $candidatePath = "/myapp/page" -> OK
            // Example: $appBasePath = "/myapp/", $candidatePath = "/otherapp/page" -> Fail
            // strtolower for case-insensitive path comparison on systems that might be case-sensitive.
            if (!str_starts_with(strtolower($candidatePath), strtolower($appBasePath))) {
                log_message('warning', "ReturnableTrait: Blocked redirect - path not within app base path. Candidate path: '{$candidatePath}', App base: '{$appBasePath}'. URL: '{$candidateUriString}'");
                return $defaultFallbackUrl;
            }

            // Security Check 2.4: Final check for '..' in the already validated path (highly unlikely to fail if getPath() is robust).
            // This is a defense-in-depth check. $candidatePath from getPath() should be clean.
            if (strpos($candidatePath, '..') !== false) {
                log_message('warning', "ReturnableTrait: Blocked absolute redirect URL - path contains '..' segments after URI parsing: '" . $candidateUriString . "' (Normalized path: '" . $candidatePath . "')");
                return $defaultFallbackUrl;
            }

            // If all checks pass, the absolute URL is considered safe.
            return $candidateUriString;
        }

        // If it's neither clearly relative (no scheme/host after parsing) nor a valid absolute URI for this app.
        // This could catch unsupported schemes (e.g., "javascript:", "ftp:") or malformed inputs.
        log_message('warning', "ReturnableTrait: Blocked redirect URL - ambiguous, non-HTTP/S, or non-compliant structure: " . $candidateUriString);
        return $defaultFallbackUrl;
    }

    /**
     * Generates the URL-encoded current full URL (including query string)
     * to be used as a 'return_to' parameter value.
     */
    protected function generateReturnToParam(): string
    {
        return urlencode((string) current_url(true)); // current_url(true) gives URI object
    }

    /**
     * Resolves and validates a "back" link.
     * Priority: 'return_to' query -> previous_url() -> defaultRoute -> site_url('/')
     */
    protected function resolveBackLink(string $defaultRoute = '', array $routeParams = []): string
    {
        $request = Services::request();
        $ultimateFallbackUrl = $defaultRoute ? site_url($defaultRoute, ...$routeParams) : site_url('/');

        // 1. Check 'return_to' query parameter
        $returnToQueryParam = $request->getGet('return_to');
        if ($returnToQueryParam) {
            $decodedUrl = urldecode($returnToQueryParam);
            $sanitizedFromQuery = $this->sanitizeRedirectUrl($decodedUrl, $ultimateFallbackUrl);
            // If sanitizeRedirectUrl didn't just return the ultimate fallback, or if the query *was* the fallback, use it.
            if ($sanitizedFromQuery !== $ultimateFallbackUrl || $decodedUrl === $ultimateFallbackUrl) {
                // Check if the original decoded URL (if it was an attempt for the fallback) is actually the fallback.
                // This ensures that if return_to=/ and ultimateFallbackUrl=/ then it's used.
                // And if return_to=safe_internal and ultimateFallbackUrl=/ then safe_internal is used.
                return $sanitizedFromQuery;
            }
        }

        // 2. Fallback to CodeIgniter's previous_url()
        $prevUrlObject = previous_url(true); // true to get URI object
        if ($prevUrlObject) {
            $currentFullUrl = (string) current_url(true);
            // Ensure previous_url is not the same as current_url to avoid self-redirects or loops
            if ((string) $prevUrlObject !== $currentFullUrl) {
                // Sanitize this session-retrieved URL.
                // If it's invalid, sanitizeRedirectUrl will return $ultimateFallbackUrl
                $sanitizedPrevUrl = $this->sanitizeRedirectUrl($prevUrlObject, $ultimateFallbackUrl);
                if ($sanitizedPrevUrl !== $ultimateFallbackUrl || (string)$prevUrlObject === $ultimateFallbackUrl) {
                    return $sanitizedPrevUrl;
                }
            }
        }

        return $ultimateFallbackUrl;
    }
}
