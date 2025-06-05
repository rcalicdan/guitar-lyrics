<?php

/**
 * Check if the current route name or URI matches one of the given wildcard patterns.
 * Works whether getMatchedRoute() returns an array or a Route object.
 *
 * @param  string|string[]  $patterns
 */
function is_route_active($patterns): bool
{
    $matched = service('router')->getMatchedRoute();
    $routeName = '';

    if ($matched) {
        if (is_array($matched)) {
            $routeName = $matched[0] ?? '';
        } elseif (is_object($matched) && method_exists($matched, 'getName')) {
            $routeName = $matched->getName() ?? '';
        }
    }

    $uri = service('uri')->getPath();

    $patterns = (array) $patterns;

    foreach ($patterns as $pattern) {
        if (check_pattern($routeName, $pattern) || check_pattern($uri, $pattern)) {
            return true;
        }
    }

    return false;
}

/**
 * Match a subject string against a wildcard pattern.
 * '*' → '.*' in regex. Anchored from start (^) to end ($).
 *
 * @param  string  $subject  Route name or URI path
 * @param  string  $pattern  Pattern with '*' wildcard
 */
function check_pattern(string $subject, string $pattern): bool
{
    if ($subject === $pattern) {
        return true;
    }

    $escaped = preg_quote($pattern, '/');
    $regex = '/^'.str_replace('\*', '.*', $escaped).'$/';

    return (bool) preg_match($regex, $subject);
}

/**
 * Blade helper: returns 'active' if matched, else empty string.
 *
 * @param  string|string[]  $patterns
 */
function active_class($patterns): string
{
    return is_route_active($patterns) ? 'active' : '';
}
