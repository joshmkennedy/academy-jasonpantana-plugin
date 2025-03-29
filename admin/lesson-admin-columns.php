<?php

use JP\CustomAdminColumn;
use \LearnDash\Core\Models\Lesson;

$lessonTypeColumn = new class extends CustomAdminColumn {
    public function __construct() {
        parent::__construct('sfwd-lessons', 'lesson-program-column', 'Program', 2);
    }

    public function render(string $column, int $postId): void {

        $lesson = Lesson::create_from_post(get_post($postId));
        if($course = $lesson->get_course()){
            echo $course->get_title();
            return;
        }
        echo "No course associated.";
    }
};

$lessonTypeColumn->register();
