<?php
namespace JP;

class SessionCard implements CardInterface {
    private LessonCategoryService $lessonCategoryService;
    public function __construct() {
        $this->lessonCategoryService = new LessonCategoryService();
    }

    public function render(\WP_Post $post): void {
?>
        <h1><?= $post->post_title ?></h1>
<?php
    }
}
