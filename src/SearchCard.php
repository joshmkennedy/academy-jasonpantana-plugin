<?php

namespace JP;
use JP\Card\CardInterface;
use JP\Card\SearchResourcCard;
use JP\Card\SearchSessionCard;
use JP\Card\SearchVideoCourseCard;

class SearchCard {
    public CardInterface $cardRenderer;
    public function __construct(public \WP_Post $post) {
        $this->cardRenderer = match (true) {
            $this->isResource($post) => $this->cardRenderer = new SearchResourcCard($post),
            $this->isSession($post) => $this->cardRenderer = new SearchSessionCard($post),
            $this->isEssential($post) => $this->cardRenderer = new SearchVideoCourseCard($post),
            default => $this->cardRenderer = new SearchResourcCard($post),
        };
    }

    public function render(): void {
        $this->cardRenderer->render();
    }

    public function isResource(\WP_Post $post): bool {
        if ($post->post_type === "sfwd-lessons") {
            $programId = learndash_get_course_id($post->ID);
            $program = get_post($programId);
            return (bool)$program && $program->post_name === "resources";
        }
        return false;
    }

    public function isSession(\WP_Post $post): bool {
        if ($post->post_type === "sfwd-lessons") {
            $programId = learndash_get_course_id($post->ID);
            $program = get_post($programId);
            if ($program && $program->post_name === "sessions") {
                return true;
            }
        }
        return false;
    }

    public function isEssential(\WP_Post $post): bool {
        if ($post->post_type === "sfwd-lessons") {
            $programId = learndash_get_course_id($post->ID);
            $program = get_post($programId);
            if ($program && $program->post_name === "essentials") {
                return true;
            }
        }
        return false;
    }
}
