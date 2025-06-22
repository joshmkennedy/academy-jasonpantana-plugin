<?php

namespace JP\Lesson;

class Session extends BaseLesson {
    public function __construct(\WP_Post $post) {
        parent::__construct($post);
    }

    public function isComingSoon(): bool {
        return get_field('coming_soon', $this->post->ID);
    }

    public function date(): string {
        $date = get_the_date('F', $this->post->ID);
        if (function_exists('get_field')) {
            $date = \get_field("session_date", $this->post->ID) ?: $date;
        }
        return $date;
    }

    /**
     * Sessions have a parent category and some times a sub cateogry
     * @param WP_Post $post
     * @return array{singular:string, plural:string, archiveLink:string, icon:string, slug:string}|false
     */
    public function sessionType() {
        $term = $this->categoryService()->sessionType($this->post);
        if (!$term) return false;
        return $this->formatCategory($term);
    }

    public function image(): string {
        $sessionType = $this->sessionType();
        if ($this->isComingSoon() && $sessionType) {
            // hard coded for now
            $thumbUrl = getAimAssetUrl($sessionType['slug'] . '-coming-soon.webp');
        } else {
            $programId = learndash_get_course_id($this->post->ID);
            $thumbUrl = $this->lessonService()->getThumbUrl($this->post, $programId, 'full');
        }
        return $thumbUrl;
    }
}
