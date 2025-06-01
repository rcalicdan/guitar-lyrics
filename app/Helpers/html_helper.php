<?php

use App\Libraries\HtmlPurifier;

if (!function_exists('purify_html')) {
    /**
     * Clean HTML content to prevent XSS while preserving formatting
     *
     * @param string|array|null $html The HTML content to purify (string, array, or null)
     * @param array $config Optional custom configuration
     * @return string|array|null Purified HTML or null if input was null
     */
    function purify_html($html, array $config = [])
    {
        if ($html === null) {
            return null;
        }
        
        if (is_array($html)) {
            return HtmlPurifier::purifyArray($html, $config);
        }
        
        return HtmlPurifier::purify($html, $config);
    }
}

if (!function_exists('is_html_safe')) {
    /**
     * Check if HTML content is already safe (contains no potentially harmful elements)
     * Useful for performance optimization to avoid unnecessary purification
     *
     * @param string|null $html The HTML content to check
     * @return bool True if the content appears safe or is null
     */
    function is_html_safe(?string $html): bool
    {
        if ($html === null || $html === '') {
            return true;
        }
        
        // Quick check for common dangerous elements/attributes
        $dangerousPatterns = [
            '/<script\b/i',                 // <script> tags
            '/javascript:/i',               // javascript: protocol
            '/on\w+\s*=/i',                 // onclick, onload, etc.
            '/<\s*iframe/i',                // <iframe> tags
            '/<\s*object/i',                // <object> tags
            '/<\s*embed/i',                 // <embed> tags
            '/expression\s*\(/i',           // CSS expressions
            '/url\s*\(\s*["\']?\s*data:/i'  // data: URLs
        ];
        
        foreach ($dangerousPatterns as $pattern) {
            if (preg_match($pattern, $html)) {
                return false;
            }
        }
        
        return true;
    }
}

if (!function_exists('display_html')) {
    /**
     * Safely display HTML content
     * Convenient for views to display purified content
     *
     * @param string|null $html The HTML content to display
     * @param bool $autoPurify Whether to automatically purify the content
     * @return string Safe HTML to display or empty string if input was null
     */
    function display_html(?string $html, bool $autoPurify = true): string
    {
        if ($html === null) {
            return '';
        }
        
        if ($autoPurify) {
            return purify_html($html);
        }
        
        return $html;
    }
}