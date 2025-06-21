<?php

namespace JP\Card;

use JP\Lesson\BaseLesson;

/** @package JP\Card */
class SearchVideoCourseCard implements CardInterface {
    private BaseLesson $lesson;
    public function __construct(private \WP_Post $post) {
        $this->lesson = new BaseLesson($this->post);
    }
    use SearchCardHeaderTrait;
    public function render(): void {
        $title = $this->lesson->title();
        $link = $this->lesson->link();
        $thumbUrl = $this->lesson->image();
        $prgramId = learndash_get_course_id($this->post->ID);
        $program = get_post($prgramId);

        $category = $this->lesson->categories();
        if ($category && count($category)) {
            $category = array_values($category)[0];
        }
?>
        <div>
            <?php $this->renderHeader($program->post_title, get_permalink($prgramId)); ?>
            <div class="embla__slide search-essential-card aim-card session-card " style="--type-color: var(--blue-700);" style="flex:1;">


                <div class="session-card__image">
                    <a href="<?= $link; ?>" class="session-card__thumb">
                        <img src="<?= $thumbUrl; ?>" alt="<?= $title; ?>" />
                    </a>

                    <div class="session-card__top-left">
                    </div>
                    <div class="session-card__top-right">
                    </div>

                </div>

                <div class="session-card__header">
                    <h4 class="card-title">
                        <a href="<?= $link; ?>"><?= $this->lesson->title(); ?></a>
                    </h4>
                    <a class="btn-link" href="<?= $link; ?>">
                        <span class="session-card__type-label">Watch</span>
                    </a>
                </div>
            </div>
        </div>
<?php
    }
}
