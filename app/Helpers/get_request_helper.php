<?php

if (!function_exists('get')) {
    function get($key, $default = null)
    {
        $request = service('request');
        return $request->getGet($key, $default);
    }
}
