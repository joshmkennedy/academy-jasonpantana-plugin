<?php

namespace JP;

class LessonCategoryNavCardAccessor implements IconCardPropertyAccessorInterface {
    public LessonCategoryService $catService;
    public function __construct() {
        $this->catService = new LessonCategoryService();
    }
    public function getItemLink(mixed $item): string {
        return get_term_link($item);
    }
    public function getItemIcon(mixed $item): string {
        return $this->catService->icon($item);
    }
    public function getItemColor(mixed $item): string {
        return $this->catService->color($item);
    }
    public function getItemTitle(mixed $item): string {
        return $item->name;
    }
}
