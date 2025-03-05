<?php

if (!function_exists("getCurrentURL")) {
    function getCurrentURL(): string {
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
            "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return $current_url;
    }
}

if (!function_exists("getAimAssetUrl")) {
    function getAimAssetUrl(string $slug): string {
        $path = JP_PLUGIN_ROOT_DIR_URL . 'assets/' . $slug;
        return $path;
    }
}

if (!function_exists("getAimAssetPath")) {
    function getAimAssetPath(string $slug): string {
        $path = JP_PLUGIN_ROOT_DIR_PATH . 'assets/' . $slug;
        return file_exists($path) ? $path : "";
    }
}

if (!function_exists("dumpSvg")) {
    function dumpSvg(string $name): string {
        $path = getAimAssetPath($name . '.svg');
        if (!$path) return '';
        return file_get_contents($path);
    }
}

if (!function_exists("isurl")) {
    /**
     * Checks if current url is the passed in relative url
     * @param string $path 
     * @return bool 
     */
    function isurl(string $path): bool {
        $actual = trailingslashit(
            preg_replace('/\?.*/', '', getCurrentURL())
        );
        $withFront = trailingslashit(site_url($path));
        error_log(print_r("$actual == $withFront", true));
        return $actual === $withFront;
    }
}

if (!function_exists("enqueueAsset")) {
    function enqueueAsset(string $slug): void {
        $assetPath = "build/$slug";

        $configPath = getAimAssetPath("$slug.asset.php");
        do_action("qm/debug", ["configPath", $configPath]);
        if($configPath){
        $config = include($configPath);
        } else{
            $config = [
                'dependencies' => [],
                'version' => time(),
            ];
        }

        if ($uri = getAimAssetUrl($assetPath . ".css")) {
            wp_enqueue_style("jp-$slug-styles", $uri, [], $config['version'], 'all');
        }
        if ($uri = getAimAssetUrl($assetPath . ".js")) {
            wp_enqueue_script("jp-$slug-script", $uri, $config['dependencies'], $config['version']);
        }
    }
}
