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
        if ($parentsOnly && is_array($cats) && count($cats) > 0) {
            $cats = array_values(array_filter($cats, fn($arg) => $arg->parent === 0));
        }

        if (!$cats || count($cats) <= 0) {
            return false;
        }

        return $cats;
    }

    /**
     * @param null|callable $filterFn 
     * @return array<WP_Term> 
     */
    public function getAll(?callable $filterFn, bool $parentsOnly = true): array {
        $args = ['taxonomy' => 'ld_lesson_category'];
        if ($parentsOnly) {
            $args['parent'] = 0;
        }
        $terms = get_terms($args);
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

    /**
     * Sessions have a parent category and some times a sub cateogry
     * @param WP_Post $post
     * @return \WP_Term|false
     */
    public function sessionType(\WP_Post $post): \WP_Term|false {
        $cats = $this->getAllFor($post, false);
        if (!$cats) return false;

        $sessionTypes = array_filter($cats, fn($arg) => LessonCategoryService::isSessionTypeCategory($arg));
        if (count($sessionTypes) <= 0) return false;
        $parent = array_find($sessionTypes, fn($arg) => $arg->parent === 0);
        if (!$parent) {
            error_log("no parent when finding the session type. Parent categories are required:\n" . print_r($sessionTypes, true));
            return false;
        }

        return $parent;
    }

    /**
     * Get ai-skill-level terms for a post
     * @param WP_Post $post
     * @return WP_Term[]|false
     */
    public function getSkillLevels(\WP_Post $post): array|false {
        $terms = get_the_terms($post->ID, 'ai-skill-level');
        if (!$terms || count($terms) <= 0) {
            return false;
        }
        return $terms;
    }

    public function resourceType(\WP_Post $post): \WP_Term|false {
        $cats = $this->getAllFor($post);
        if (!$cats) return false;

        // optimization - use reset(), as this just gets the first item in array. 
        // array_values is not needed but it makes the code more readable IMH. 
        $resourceTypes = array_values(array_filter($cats, fn($arg) => !LessonCategoryService::isSessionTypeCategory($arg)));
        if (count($resourceTypes) <= 0) return false;
        return $resourceTypes[0];
    }

    public function icon(\WP_Term|false $category): string {
        if (!$category || !function_exists('get_taxonomy_image'))
            return '';
        $icon = \get_taxonomy_image($category->term_id, true);
        $fallbackText = "Please Upload Image First!";
        if (!$icon || $icon == $fallbackText) return '<span style="font-size:.5em!important">AIM</span>';
        return $icon;
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

    public function description(\WP_Term|false $category): string {
        if (!$category)
            return '';
        return $category->description;
    }

    public static function isRoot(\WP_Term|false $category): bool {
        return $category && $category->parent === 0;
    }
}
