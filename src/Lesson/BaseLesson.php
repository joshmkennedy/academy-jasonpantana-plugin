<?php

namespace JP\Lesson;

use JP\LessonCategoryService;
use JP\LessonService;

class BaseLesson {
    private LessonCategoryService $categoryService;
    private LessonService $lessonService;

    public function __construct(public \WP_Post $post) {
        $this->categoryService = new LessonCategoryService;
        $this->lessonService = new LessonService;
    }


    public function title(): string {
        return get_the_title($this->post);
    }

    public function excerpt(): string {
        return $this->post->post_excerpt;
    }

    public function link(): string {
        return get_the_permalink($this->post);
    }

    public function image(): string {
        return $this->lessonService->getThumbUrl($this->post);
    }

    function categories() {
        $categories = $this->categoryService->getAllFor($this->post);
        if (!$categories) return false;

        return array_map([$this, 'formatCategory'], $categories);
    }

    public function skillLevel() {
        $skillLevels = $this->categoryService->getSkillLevels($this->post);
        if (!$skillLevels) return false;

        $skillLevel = array_find($skillLevels, fn($arg) => $arg->parent === 0);
        if (!$skillLevel) {
            error_log("no parent when finding the skill level. Parent categories are required:\n" . print_r($skillLevels, true));
            return false;
        }

        return $this->formatCategory($skillLevel);
    }

    /**
     * @param array<\WP_Term>|false $categories
     * @return array<array{singular:string, plural:string, archiveLink:string, icon:string, slug:string }>|false
     **/

    public function formatCategory(\WP_Term $term): array {
        return [
            'description' => $term->description,
            'slug' => $term->slug,
            'singular' => $this->categoryService->singlularLabel($term),
            'plural' => $this->categoryService->pluralLabel($term),
            'archiveLink' => get_term_link($term),
            'icon' => $this->categoryService->icon($term),
        ];
    }

    public function date(): string {
        return get_the_date('D M Y', $this->post);
    }

    public function categoryService(): LessonCategoryService {
        return $this->categoryService;
    }
    public function lessonService(): LessonService {
        return $this->lessonService;
    }
}
