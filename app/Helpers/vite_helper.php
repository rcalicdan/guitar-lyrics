<?php

use App\Libraries\ViteAssetManager;

if (! function_exists('vite_asset')) {
    function vite_asset($entrypoints, bool $includeViteClient = true): string
    {
        static $viteManager = null;

        if ($viteManager === null) {
            $viteManager = new ViteAssetManager;
        }

        return $viteManager->generateAssets($entrypoints, $includeViteClient);
    }
}

if (! function_exists('vite_asset_with_config')) {
    function vite_asset_with_config($entrypoints, array $config = [], bool $includeViteClient = true): string
    {
        $viteManager = ViteAssetManager::configure($config);

        return $viteManager->generateAssets($entrypoints, $includeViteClient);
    }
}
