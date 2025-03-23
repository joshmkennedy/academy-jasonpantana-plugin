<?php

namespace JP;

use WP_Post;
/*
 * A collection of Vimeo utilities
 */

class VimeoUtils {
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
     * Gets thumbail from id
     * @param string $id id of the vimeo video
     * @param string|null $fallback fallback image url
     * @return string 
     **/
    public static function getThumb(string $id, null|string $fallback = null): string {
        if (!$fallback) {
            $fallback = getAimAssetUrl("fallbackvidthum.avif");
        }
        //TODO: implement this
        error_log(print_r("video embed is not implemented", true));
        return $fallback;
    }
}
