<?php

namespace JP\Card;

use JP\Lesson\Session;

class SessionCard implements CardInterface {
    private Session $lesson;
    public function __construct(private \WP_Post $post) {
        $this->lesson = new Session($post);
    }

    public function render(): void {
        $title = $this->lesson->title();
        $link = $this->lesson->link();
        $comingSoon = $this->lesson->isComingSoon();

        $sessionType = $this->lesson->sessionType();

        $skillLevel = $this->lesson->skillLevel();
        $skillLeveLabel = $skillLevel ? $skillLevel['singular'] : '';
        $skillLevelDescription = $skillLevel ? $skillLevel['description'] : "";


        $icon = $sessionType['icon'];

        $thumbUrl = $this->lesson->image();
        $date = $this->lesson->date();
?>

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
                    <?php if ($skillLevel): ?>
                    <div
                        class="session-card__session-subtype-label shimmer"
                        <?= $skillLevelDescription
                            ? sprintf("data-tippy-content='%s'", $skillLevelDescription)
                            : ""; ?>">
                        <?= $skillLeveLabel; ?>
                    </div>
                    <?php endif; ?>
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
<?php
    }
}
