<?php
namespace JP;

class LessonService {
    public function __construct() {
    }

    public function getThumbUrl(\WP_Post|null $post, ?int $parentId = null, string $size = 'full'): string {
        if (!$post) return '';

        if (has_post_thumbnail($post)) return get_the_post_thumbnail_url($post->ID, $size);

        $videoUrl = VimeoUtils::firstEmbedUrl($post);
        if ($videoUrl) {
            $vimeoId = VimeoUtils::getId($videoUrl);
            $thumbUrl = VimeoUtils::getThumb($vimeoId);

            if ($thumbUrl) return $thumbUrl;
        }
        if ($parentId) {
            $parent = get_post($parentId);
            if ($parent) {
                return get_the_post_thumbnail_url($parent->ID, $size);
            }
        }
        return '';
    }
}
