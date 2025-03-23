<?php

namespace JP;

use WP_Post;
use WP_Term;

class LessonCategoryService {
    public function __construct() {
    }

    /**
     * @param WP_Post $post
     * @return WP_Term[]|false
     */
    public function getAllFor(WP_Post $post): array|false {
        $cats = get_the_terms($post->ID, 'ld_lesson_category');
        if (!$cats || count($cats) <= 0)
            return false;
        return $cats;
    }

    /**
     * @param null|callable $filterFn 
     * @return array<WP_Term> 
     */
    public function getAll(?callable $filterFn): array {
        $terms = get_terms(['taxonomy' => 'ld_lesson_category']);
        if ($filterFn) {
            return array_filter($terms, $filterFn);
        }
        return $terms;
    }

    /**
     * Checks if the term is a lesson type category
     * @param WP_Term $term 
     * @return bool 
     */
    public static function isSessionTypeCategory(\WP_Term|null|false $term): bool {
        return $term && str_starts_with($term->slug, 'session-');
    }

    public function sessionType(\WP_Post $post): \WP_Term|false {
        $cats = $this->getAllFor($post);
        if (!$cats) return false;

        $sessionTypes = array_filter($cats, fn($arg) => LessonCategoryService::isSessionTypeCategory($arg));
        if (count($sessionTypes) <= 0) return false;
        return $sessionTypes[0];
    }

    public function resourceType(\WP_Post $post): \WP_Term|false {
        $cats = $this->getAllFor($post);
        if (!$cats) return false;

        $resourceTypes = array_filter($cats, fn($arg) => !LessonCategoryService::isSessionTypeCategory($arg));
        if (count($resourceTypes) <= 0) return false;
        return $resourceTypes[0];
    }

    public function icon(\WP_Term|false $category): string {
        if (!$category || !function_exists('get_taxonomy_image'))
            return '';
        return \get_taxonomy_image($category->term_id, true);
    }

    public function color(\WP_Term|false $category): string {
        $defaultColor = 'var(--blue-700)';
        if (!$category || !function_exists('get_field'))
            return $defaultColor;
        return \get_field('color', $category) ?: $defaultColor;
    }
}
