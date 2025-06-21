<?php

namespace JP\Card;

use JP\Lesson\Session;

/** @package JP\Card */
class SearchSessionCard implements CardInterface {
    use SearchCardHeaderTrait;

    private Session $lesson;
    public function __construct(private \WP_Post $post) {
        $this->lesson = new Session($post);
    }

    public function render(): void {
        $title = $this->lesson->title();
        $link = $this->lesson->link();
        $comingSoon = $this->lesson->isComingSoon();

        $sessionTypeConfig = $this->lesson->sessionTypeConfig();
        $sessionType = $sessionTypeConfig['type'];
        $sessionSubType = $sessionTypeConfig['subtype'];
        $subTypeLabel = $sessionSubType ? $sessionSubType['singular'] : '';
        $sessionSubTypeDescription = $sessionSubType ? $sessionSubType['description'] : "";

        $icon = $sessionType['icon'];

        $thumbUrl = $this->lesson->image();
        $date = $this->lesson->date();

        $prgramId = learndash_get_course_id($this->post->ID);
        $program = get_post($prgramId);
?>
        <div>
            <?php $this->renderHeader($program->post_title, get_permalink($prgramId)); ?>
            <div class="embla__slide aim-card session-card " style="--type-color: var(--blue-700);">


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

                    <?php if (has_block('core/embed', $this->post)): ?>
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
                        <a href="<?= $link; ?>"><?= $this->lesson->title(); ?></a>
                    </h4>
                    <p class="session-card__type">
                        <span class="session-card__date"><?= $date; ?></span>
                        <span class="session-card__type-label"><?= $sessionType ? $sessionType['singular'] : 'Resource'; ?></span>
                    </p>
                </div>
            </div>
        </div>
<?php
    }
}
