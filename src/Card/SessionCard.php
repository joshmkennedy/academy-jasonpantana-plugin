<?php

namespace JP\Card;

use JP\LessonCategoryService;
use JP\LessonService;

class SessionCard implements CardInterface {
    private LessonCategoryService $lessonCategoryService;
    private LessonService $lessonService;
    public function __construct() {
        $this->lessonCategoryService = new LessonCategoryService();
        $this->lessonService = new LessonService();
    }

    public function render(\WP_Post $post): void {
        $title = get_the_title($post->ID);
        $link = get_the_permalink($post->ID);
        $comingSoon = get_field('coming_soon', $post->ID);
        $date = get_the_date('F', $post->ID);
        if (function_exists('get_field')) {
            $date = \get_field("session_date", $post->ID) ?: $date;
        }

        $sessionTypeConfig = $this->lessonCategoryService->sessionType($post);
        $sessionType = $sessionTypeConfig['type'];

        $sessionSubType = $sessionTypeConfig['subtype'];
        $subTypeLabel = trim($sessionSubType ? $this->lessonCategoryService->singlularLabel($sessionSubType) : "");
        $sessionSubTypeDescription = $sessionSubType ? $this->lessonCategoryService->description($sessionSubType) : "";

        $icon = $this->lessonCategoryService->icon($sessionType);

        $color = $this->lessonCategoryService->color($sessionType);

        if ($comingSoon && $sessionType) {
            // hard coded for now
            $thumbUrl = getAimAssetUrl($sessionType->slug . '-coming-soon.webp');
        } else {
            $programId = learndash_get_course_id($post->ID);
            $thumbUrl = $this->lessonService->getThumbUrl($post, $programId, 'full');
        }
?>

        <div class="embla__slide aim-card session-card " style="--type-color: <?= $color; ?>;">
            <div class="session-card__image">
                <a href="<?= $link; ?>" class="session-card__thumb">
                    <img src="<?= $thumbUrl; ?>" alt="<?= $title; ?>" />
                </a>

                <div class="session-card__top-left">
                    <div class="session-card__session-type-icon">
                        <?= $icon; ?>
                    </div>
                </div>
                <div class="session-card__top-right">
                    <div
                        class="session-card__session-subtype-label shimmer"
                        <?= $sessionSubTypeDescription
                            ? sprintf("data-tippy-content='%s'", $sessionSubTypeDescription)
                            : ""; ?>"><?= $subTypeLabel; ?></div>
                </div>

            </div>

            <div class="session-card__header">

                <?php if (has_block('core/embed', $post)): ?>
                    <div class="sessionAction">
                        <a href="<?= $link; ?>" class="sessionAction__button sessionAction__button--play">
                            <?= dumpSvg('play-circle'); ?>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if ($comingSoon): ?>
                    <div class="session-card__session-coming-soon">
                        coming soon
                    </div>
                <?php endif; ?>
                <h4 class="card-title">
                    <a href="<?= $link; ?>"><?= get_the_title($post->ID); ?></a>
                </h4>
                <p class="session-card__type">
                    <span class="session-card__date"><?= $date; ?></span>
                    <span class="session-card__type-label"><?= $sessionType ? $this->lessonCategoryService->singlularLabel($sessionType) : ''; ?></span>
                </p>
            </div>
        </div>
<?php
    }
}
