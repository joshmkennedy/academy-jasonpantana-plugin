<?php

namespace JP\Card;

use JP\Lesson\BaseLesson;

/** @package JP\Card */
class VideoCourseCard implements CardInterface {
    private BaseLesson $lesson;
    public function __construct(private \WP_Post $post) {
        $this->lesson = new BaseLesson($this->post);
    }

    public function render(): void {
        $thumbUrl = $this->lesson->image();
    ?>
        <a href="<?= $this->lesson->link(); ?>" class="embla__slide aim-card essentials-card " style="--bg-image: url('<?= $thumbUrl; ?>');">
            <h4 class="card-title" title="<?= $this->lesson->title(); ?>">
                <span class="icon"><?= dumpSvg('play-circle'); ?></span>
                <span><?= $this->lesson->title(); ?></span>
            </h4>
        </a>
    <?php
    }
}
