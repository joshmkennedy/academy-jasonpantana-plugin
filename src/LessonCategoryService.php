<?php
namespace JP;

use WP_Post;
use WP_Term;

class LessonCategoryService {
    public function __construct() {
    }

    /**
     * @param WP_Post $post
     * @param bool $parentsOnly
     * @return WP_Term[]|false
     */
    public function getAllFor(WP_Post $post, bool $parentsOnly = true): array|false {
        $cats = get_the_terms($post->ID, 'ld_lesson_category');
        if (!$cats || count($cats) <= 0)
            return false;
        if ($parentsOnly) {
            $cats = array_filter($cats, fn($arg) => LessonCategoryService::isRoot($arg));
        }
        return $cats;
    }

    /**
     * @param null|callable $filterFn 
     * @return array<WP_Term> 
     */
    public function getAll(?callable $filterFn): array {
        $terms = get_terms(['taxonomy' => 'ld_lesson_category', 'parent'=>0]);
        if ($filterFn) {
            return array_filter($terms, $filterFn);
        }
        return $terms;
    }

    public function getChildCategories(\WP_Term|false $term): array|false {
        if (!$term) return false;
        return get_terms(['taxonomy' => 'ld_lesson_category', 'parent'=>$term->term_id]);
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

    public function sessionSubType(\WP_Term|false $sessionType): \WP_Term|false {
        if(!$sessionType || !LessonCategoryService::isSessionTypeCategory($sessionType)) return false;
        $childCategories = $this->getChildCategories($sessionType);
        if (!$childCategories || count($childCategories) <= 0) return false;
        return $childCategories[0];
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
        // DONT DO THE CUSTOM ICON COLOR - 2025-04-06 
        // $defaultColor = 'var(--blue-700)';
        // if (!$category || !function_exists('get_field'))
        //     return $defaultColor;
        // return \get_field('color', $category) ?: $defaultColor;
        return 'var(--blue-700)';
    }

    public function singlularLabel(\WP_Term|false $category): string {
        if (!$category || !function_exists('get_field'))
            return '';
        return \get_field('single', $category) ?: $category->name;
    }
    public function pluralLabel(\WP_Term|false $category): string {
        if (!$category)
            return '';
        return $category->name;
    }

    public static function isRoot(\WP_Term|false $category): bool {
        return $category && $category->parent === 0;
    }
}
