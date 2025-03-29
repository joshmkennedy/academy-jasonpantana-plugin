<?php

use JP\CustomAdminColumn;
use \LearnDash\Core\Models\Lesson;

$lessonTypeColumn = new class extends CustomAdminColumn {
    public function __construct() {
        parent::__construct('sfwd-lessons', 'lesson-program-column', 'Program');
    }

    public function render(string $column, int $postId): void {

        $lesson = Lesson::create_from_post(get_post($postId));
        error_log(print_r($lesson, true));
        echo "hi";
    }
};

$lessonTypeColumn->register();
