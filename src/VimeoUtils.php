<?php

namespace JP;

use WP_Post;
/*
 * A collection of Vimeo utilities
 */

class VimeoUtils {
    const API_BASE_URL = "https://api.vimeo.com";
    /**
     * Get the first embed url from a post content
     * @param WP_Post $post 
     * @return string|null 
     */
    public static function firstEmbedUrl(WP_Post $post): string|null {
        if (!has_block("core/embed", $post)) return null;
        $blocks = parse_blocks($post->post_content);
        foreach ($blocks as $block) {
            if (isset($block['blockName']) && $block['blockName'] === "core/embed") {
                if (isset($block['attrs']['url'])) {
                    return $block['attrs']['url'];
                }
            }
        }
        error_log("no vimeo embed found");
        return null;
    }

    /**
     * Get the Vimeo ID from a url
     * @param string $url 
     * @return string|null 
     */
    public static function getId(string $url): string|null {
        $vimeoId = null;
        if (preg_match('/vimeo\.com\/([0-9]+)/', $url, $matches)) {
            $vimeoId = $matches[1];
        }
        return $vimeoId;
    }

    /**
     * Gets thumbail from id using the vimeo api
     * It will aslo cache the result with transients jp_vimeo_thumb_{id}
     * @param string $id id of the vimeo video
     * @param string|null $fallback fallback image url
     * @return string 
     **/
    public static function getThumb(string $id, null|string $fallback = null): string {
        if (!$fallback) {
            $fallback = getAimAssetUrl("fallbackvidthum.avif");
        }
				return $fallback;
        if (get_transient("jp_vimeo_thumb_$id")) {
            return get_transient("jp_vimeo_thumb_$id");
        }
        $vimeoResponse = self::vimeoApiGet("/videos/$id/pictures");
        if (!isset($vimeoResponse['data'])) {
            return $fallback;
        }
        $thumbnails = $vimeoResponse['data'][0]['sizes'];
        $thumbnail = array_filter($thumbnails, fn($arg) => $arg['width'] > 600);
        $thumbnail = array_shift($thumbnail);
        if (!$thumbnail) {
            return $fallback;
        }
        $thumbnailUrl = $thumbnail['link'];
        set_transient("jp_vimeo_thumb_$id", $thumbnailUrl, \MONTH_IN_SECONDS);
        return $thumbnailUrl;
    }

    public static function vimeoApiGet(string $path): array {
        $token = getAimVimeoToken();
        if (!$token) {
            error_log("no token");
            return [];
        }
        $url = self::API_BASE_URL . $path;
        $headers = [
            'Authorization' => "Bearer $token",
        ];
        $response = wp_remote_get($url, [
            'headers' => $headers,
        ]);
        if (is_wp_error($response)) {
            error_log("error getting vimeo api");
            return [];
        }
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
}
