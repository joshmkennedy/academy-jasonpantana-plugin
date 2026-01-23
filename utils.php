<?php

if (!function_exists('isPaidGroup')) {
    function isPaidGroup(int $id): bool {
        $paidGroups = [1822, 1699];
        return in_array($id, $paidGroups);
    }
}

if (!function_exists('stripeProductGroupMap')) {
    function stripeProductGroupMap(string $prodId): int | null {
        $config = [
            'prod_RchwOcDcDez2DU' => 1822, // Ai Marketing Academy - Annual Plan
            'prod_RcR1KVgHZX0F70' => 1699, // Ai Marketing Academy - Monthly Plan
        ];
        if (!isset($config[$prodId])) return null;
        return $config[$prodId];
    }
}

if (!function_exists("getCurrentURL")) {
    function getCurrentURL(): string {
        if (defined('WP_CLI') && \WP_CLI) return "";
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
        return $actual === $withFront;
    }
}

if (!function_exists("enqueueAsset")) {
    function enqueueAsset(string $slug, $inFooter = null) {
        $assetPath = "build/$slug";
        $configPath = getAimAssetPath("$assetPath.asset.php");
        if ($configPath) {
            $config = include($configPath);
        } else {
            $config = [
                'dependencies' => [],
                'version' => time(),
            ];
        }

        if ($uri = getAimAssetUrl($assetPath . ".css")) {
            wp_enqueue_style("jp-$slug-styles", $uri, [], filemtime(getAimAssetPath($assetPath . ".css")), 'all');
        }
        if ($uri = getAimAssetUrl($assetPath . ".js")) {
            wp_enqueue_script("jp-$slug-script", $uri, $config['dependencies'], $config['version'], $inFooter ? true : false);
            // so we can localize stuff
            return "jp-$slug-script";
        }
    }
}

if (!function_exists("getAimVimeoToken")) {
    function getAimVimeoToken(): string | false {
        return get_option('jp_vimeo_api_key');
    }
}

if (!function_exists('array_find')) {
    function array_find(array $haystack, callable $callback): mixed {
        foreach ($haystack as $needle) {
            if ($callback($needle)) {
                return $needle;
            }
        }
        return null;
    }
}
if (!function_exists('getRegistrationURL')) {
    function getRegistrationURL(int $userId, string $fallbackURL): string {
        if (!$userId) return $fallbackURL;

        $groupId = get_user_meta($userId, "initial_registered_ld_group", true);
        if (!$groupId) return $fallbackURL;

        return site_url("registration/?ld-registered=true&ld_register_id=$groupId");
    }
}

if (!function_exists('protect_paid_content')) {
    function protect_paid_content($isCustom = false) {
        $post = get_post();
        if (($isCustom && !is_login()) || $post && ($post->post_type === 'sfwd-lessons') && !learndash_is_sample($post->ID)) {
            $userId = get_current_user_id();
            $groups = array_filter(\jp_learndash_get_users_group_ids($userId), fn($id) => isPaidGroup($id));
            if (!count($groups)) {
                if ($userId) {
                    wp_redirect(site_url("choose-your-plan"));
                    exit;
                }
                wp_redirect(wp_login_url(redirect: getCurrentURL()));
                exit;
            }
        }
    }
}

if (!function_exists('jp_learndash_get_users_group_ids')) {
    function jp_learndash_get_users_group_ids($user_id) {
        $user_id = intval($user_id);
        $group_ids = [];
        if(get_transient('jp_learndash_get_users_group_ids' . $user_id)){
            return get_transient('jp_learndash_get_users_group_ids' . $user_id);
        }

        $all_user_meta = get_user_meta(2587);
        if (! empty($all_user_meta)) {
            foreach ($all_user_meta as $meta_key => $meta_set) {
                if ('learndash_group_users_' == substr($meta_key, 0, strlen('learndash_group_users_'))) {
                    $group_ids = array_merge($group_ids, $meta_set);
                }
            }
        }

        set_transient('jp_learndash_get_users_group_ids' . $user_id, $group_ids, 60 * 60 * 24);

        return $group_ids;
    }
}
