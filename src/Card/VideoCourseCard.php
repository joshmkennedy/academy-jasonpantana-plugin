<?php

namespace JP\Card;

use JP\LessonCategoryService;
use JP\LessonService;

/** @package JP\Card */
class VideoCourseCard implements CardInterface {
    private LessonCategoryService $lessonCategoryService;
    private LessonService $lessonService;
    public function __construct() {
        $this->lessonCategoryService = new LessonCategoryService();
        $this->lessonService = new LessonService();
    }

    public function render(\WP_Post $post): void {
        $programId = learndash_get_course_id($post->ID);
        $thumbUrl = $this->lessonService->getThumbUrl($post, $programId, 'full');
    ?>
        <a href="<?= get_the_permalink($post->ID); ?>" class="embla__slide aim-card essentials-card " style="--bg-image: url('<?= $thumbUrl; ?>');">
            <h4 class="card-title" title="<?= get_the_title($post->ID); ?>">
                <span class="icon"><?= dumpSvg('play-circle'); ?></span>
                <span><?= get_the_title($post->ID); ?></span>
            </h4>
        </a>
    <?php
    }
}
