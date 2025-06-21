<?php

namespace JP;
use JP\Card\CardInterface;
use JP\Card\ResourceCard;
use JP\Card\SessionCard;
use JP\Card\VideoCourseCard;

class LessonCard {
    public CardInterface $cardRenderer;
    public function __construct(public \WP_Post $post) {
        $this->cardRenderer = match (true) {
            $this->isResource($post) => $this->cardRenderer = new ResourceCard,
            $this->isSession($post) => $this->cardRenderer = new SessionCard,
            $this->isEssential($post) => $this->cardRenderer = new VideoCourseCard,
            default => $this->cardRenderer = new ResourceCard(),
        };
    }

    public function render(): void {
        error_log(print_r([
            "isEssential" => $this->isEssential($this->post),
            "isSession" => $this->isSession($this->post),
            "isResource" => $this->isResource($this->post),
        ], true));
        $this->cardRenderer->render($this->post);
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
