<?php

namespace JP;

use WP_Post;
use WP_Term;

/** @package JP */
class Lolole {
    private LessonCategoryService $lessonCategoryService;
    private LessonService $lessonService;
    public function __construct() {
        // hardcoded for now but one day we could use dependency injection
        $this->lessonCategoryService = new LessonCategoryService();
        $this->lessonService = new LessonService();
    }

    public function render(): string {
        ob_start();
?>
        <div class="lolole-wrapper">
            <?php $this->renderLessonsSection(
                title: 'Sessions',
                programId: 55,
                cardCB: fn($args, $programId) => $this->sessionCard($args, $programId),
            ); ?>

            <?php $this->renderLessonCategorySection(
                title: 'Resources',
                programId: 1273,
                cardCB: fn($args) => $this->resourceCategoryCard($args),
            ); ?>

            <?php $this->renderLessonsSection(
                title: 'Essentials',
                programId: 1294,
                cardCB: fn($lesson, $programId) => $this->essentialCard($lesson, $programId),
            ); ?>
        </div>
    <?php
        return ob_get_clean();
    }

    private function essentialCard(\WP_Post $post, int $programId): void {
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

    /**
     * Session Card
     * ------------
     * Will default to just showing title with the featured image and date default color can slate
     * if cat set then will add the cat icon
     * in the cat color
     * add the color to the frame
     * after title will add the date plus the cat
     *
     * @param WP_Post $post
     * @return void
     */
    private function sessionCard(\WP_Post $post, int $programId): void {
        $title = get_the_title($post->ID);
        $link = get_the_permalink($post->ID);

        $date = get_the_date('F', $post->ID);
        if (function_exists('get_field')) {
            $date = \get_field("session_date", $post->ID) ?: $date;
        }

        $sessionType = $this->lessonCategoryService->sessionType($post);
        $icon = $this->lessonCategoryService->icon($sessionType);
        $color = $this->lessonCategoryService->color($sessionType);
        $thumbUrl = $this->lessonService->getThumbUrl($post, $programId, 'full');

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
            </div>

            <div class="session-card__header">

                <?php if (has_block('core/embed', $post)): ?>
                    <div class="sessionAction">
                        <a href="<?= $link; ?>" class="sessionAction__button sessionAction__button--play">
                            <?= dumpSvg('play-circle'); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <h4 class="card-title">
                    <a href="<?= $link; ?>"><?= get_the_title($post->ID); ?></a>
                </h4>
                <p class="session-card__type">
                    <span class="session-card__date"><?= $date; ?></span>
                    <span class="session-card__type-label"><?= $sessionType ? $sessionType->name : ''; ?></span>
                </p>
            </div>
        </div>
    <?php
    }

    private function resourceCategoryCard(\WP_Term $cat): void {
        $color = $this->lessonCategoryService->color($cat);
        $icon = $this->lessonCategoryService->icon($cat);
        $link = get_term_link($cat);

    ?>
        <div class="aim-card icon-card " style="--color: <?= $color; ?>; --slide-size:max(16.6%, 75px);">
            <div class="icon-card__contents">
                <a href="<?= $link; ?>" class="icon-card__thumb">
                    <?= $icon; ?>
                </a>
                <h4 class="icon-card__title card-title">
                    <a href="<?= $link; ?>"><?= $cat->name; ?></a>
                </h4>
            </div>
        </div>
    <?php
    }

    private function resourceCard(\WP_Post $post, int $programId): void {
        $cats = $this->lessonCategoryService->getAllFor($post);
        $excerpt = $post->post_excerpt;
    ?>
        <div class="embla__slide aim-card resource-card ">
            <div class="card-contents">
                <div class="meta">
                    <?php
                    if ($cats) {
                        foreach ($cats as $cat) {
                    ?>
                            <div class="meta-item">
                                <span class="meta-item-icon">
                                    <?= $this->lessonCategoryService->icon($cat); ?>
                                </span>
                                <span class="meta-item-label"><?= $cat->name; ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <h4 class="card-title">
                    <a href="<?= get_the_permalink($post->ID); ?>">
                        <?= get_the_title($post->ID); ?>
                    </a>
                </h4>
                <p class="excerpt"><?= $excerpt; ?></p>

                <a href="<?= get_the_permalink($post->ID); ?>" class="link">
                    View <?= $cats[0]->name ?? 'Resource'; ?>
                </a>
            </div>
        </div>
    <?php
    }

    /**
     * @param string $title 
     * @param int $programId 
     * @param callable $cardCB 
     * @param ?array<WP_Post> $collection 
     * @return void 
     */
    private function renderLessonsSection(string $title, int $programId,  callable $cardCB, ?array $collection = null): void {
        if (!$collection) {
            /** @var array<\WP_Post> $collection */
            $collection = \learndash_get_lesson_list($programId, ['num' => 25]);
        }

        $post = get_post($programId);
    ?>
        <div class="lolole-section">
            <header>
                <div class="section-header-flex-row">
                    <div class="section-title">
                        <h2>
                            <?= $title ?>
                        </h2>
                    </div>

                    <div class="right">
                        <a href="<?= get_the_permalink($programId); ?>" class="view-all-button">View All</a>
                    </div>
                </div>

                <?php if ($post->post_excerpt): ?>
                    <p class="section-description"><?= $post->post_excerpt; ?></p>
                <?php endif; ?>
            </header>

            <div class="lolole-slider embla">
                <div class="lolole__controls">
                    <div class="embla__buttons">
                        <button class="embla__button--prev embla__button">
                            <?= dumpSvg('chevron-left'); ?>
                        </button>
                        <button class="embla__button--next embla__button">
                            <?= dumpSvg('chevron-right'); ?>
                        </button>
                    </div>
                </div>
                <div class="embla__viewport">
                    <div class="embla__container">
                        <?php foreach ($collection as $item) { ?>
                            <?= $cardCB($item, $programId); ?>
                        <?php } ?>
                        <?php if (count($collection) > 3) { ?>
                            <?php $this->lastSlide($programId); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <footer>
                <a href="<?= get_the_permalink($programId); ?>" class="view-all-button">View All</a>
            </footer>
        </div>
    <?php
    }

    /**
     * @param string $title 
     * @param int $programId 
     * @param callable $cardCB 
     * @param ?array<WP_Term> $collection 
     * @return void 
     */
    private function renderLessonCategorySection(string $title, int $programId, callable $cardCB, ?array $collection = null): void {
        if (!$collection) {
            $collection =  array_filter(
                get_terms(['taxonomy' => 'ld_lesson_category']),
                // Only non resource cats currently are for sessions so we take out those
                fn($arg) => !$this->lessonCategoryService->isSessionTypeCategory($arg) && $arg
            );
        }

        $post = get_post($programId);
    ?>
        <div class="lolole-section">
            <header>
                <div class="section-header-flex-row">
                    <div class="section-title">
                        <h2>
                            <?= $title ?>
                        </h2>
                    </div>

                    <div class="right">
                        <a href="<?= get_the_permalink($programId); ?>" class="view-all-button">View All</a>
                    </div>
                </div>

                <?php if ($post->post_excerpt): ?>
                    <p class="section-description"><?= $post->post_excerpt; ?></p>
                <?php endif; ?>
            </header>

            <div class="lolole-grid ">
                <?php foreach ($collection as $item) { ?>
                    <?= $cardCB($item); ?>
                <?php } ?>
            </div>
            <footer>
                <a href="<?= get_the_permalink($programId); ?>" class="view-all-button">View All</a>
            </footer>
        </div>
    <?php
    }

    private function lastSlide(int $programId): void {
        $link = get_the_permalink($programId);

    ?>
        <div class="embla__slide aim-card icon-card" style="--color:  hsl(from #cbd5e0 h s 40%);">
            <div class="icon-card__contents">
                <a href="<?= $link; ?>" class="icon-card__thumb">
                    <?= dumpSvg('grid'); ?>
                </a>
                <h4 class="icon-card__title card-title">
                    <a href="<?= $link; ?>">
                        View All
                    </a>
                </h4>
            </div>
        </div>
<?php
    }
}
