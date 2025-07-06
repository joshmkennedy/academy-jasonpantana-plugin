<?php

namespace JP\Profile;

use JP\LessonCategoryService;
use JP\LessonService;
use WP_Post;
use WP_Term;

/** @package JP\Profile */
class Lolole {
    protected LessonCategoryService $lessonCategoryService;
    protected LessonService $lessonService;


    public function __construct() {
        // hardcoded for now but one day we could use dependency injection
        $this->lessonCategoryService = new LessonCategoryService();
        $this->lessonService = new LessonService();
    }

    public function render(): void {
        return;
    }

    protected function essentialCard(\WP_Post $post, int $programId): void {
        (new \JP\Card\VideoCourseCard($post))->render();
    }

    /**
     * Session Card
     * ------------
     * Will default to just showing title with the featured image and date default color can slate
     * if cat set then will add the cat icon in the cat color add the color to the frame
     * after title will add the date plus the cat
     *
     * @param WP_Post $post
     * @return void
     */
    protected function sessionCard(\WP_Post $post, int $programId): void {
        (new \JP\Card\SessionCard($post))->render();
    }

    protected function resourceCategoryCard(\WP_Term $cat): void {
        $color = $this->lessonCategoryService->color($cat);
        $icon = $this->lessonCategoryService->icon($cat);
        $link = get_term_link($cat);

?>
        <div class="aim-card icon-card embla__slide" style="--color: <?= $color; ?>; --slide-size:166px;">
            <div class="icon-card__contents">
                <a href="<?= $link; ?>" class="icon-card__thumb">
                    <?= $icon; ?>
                </a>
                <h4 class="icon-card__title card-title">
                    <a href="<?= $link; ?>"><?= $cat ? $this->lessonCategoryService->pluralLabel($cat) : ''; ?></a>
                </h4>
            </div>
        </div>
    <?php
    }

    /**
     * @param string $title 
     * @param int $programId 
     * @param callable $cardCB 
     * @param ?array<WP_Post> $collection 
     * @param ?string $slideWidth sets the --slide-size css variable
     * @param ?string $description
     *
     * @return void 
     */
    protected function renderLessonsSection(string $title, int $programId,  callable $cardCB, ?array $collection = null, ?string $description = null, ?string $slideWidth = null): void {
        if (!$collection) {
            error_log("no collection: " . $title);
            /** @var array<\WP_Post> $collection */
            $collection = \learndash_get_lesson_list($programId, ['num' => 25]);
        }

        $post = get_post($programId);
    ?>
        <div class="lolole-section">
            <header>
                <div class="section-header-flex-row section-title-wrapper">
                    <div class="section-title">
                        <h2>
                            <?= $title ?>
                        </h2>
                    </div>

                </div>

                <?php if ($description): ?>
                    <p class="section-description"><?= $description; ?></p>
                <?php elseif ($post->post_excerpt): ?>
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
                    <div class="right">
                        <a href="<?= get_the_permalink($programId); ?>" class="view-all-button">View All</a>
                    </div>
                </div>
                <div class="embla__viewport">
                    <div class="embla__container" <?php if ($slideWidth): ?>style="--slide-size:<?= $slideWidth; ?>;" <?php endif; ?>>
                        <?php foreach ($collection as $item) { ?>
                            <?= $cardCB($item, $programId); ?>
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

    protected function resourceCatgories(): array {
        return array_filter(
            get_terms(['taxonomy' => 'ld_lesson_category']),
            // Only non resource cats currently are for sessions so we take out those
            fn($arg) => !$this->lessonCategoryService->isSessionTypeCategory($arg) && $arg
        );
    }

    /**
     * @param string $title 
     * @param int $programId 
     * @param callable $categoryCardCB
     * @param callable $collectionCardCB
     * @param ?array<WP_Post> $collection 
     * @param ?array<WP_Term> $categories
     * @param ?string $slideWidth sets the --slide-size css variable
     * @return void 
     */
    protected function renderLessonCategorySection(string $title, int $programId, callable $categoryCardCB, callable $collectionCardCB, ?array $collection = null, ?array $categories = null, ?string $slideWidth = null): void {
        if (!$categories) {
            $categories =  array_filter(
                get_terms(['taxonomy' => 'ld_lesson_category']),
                // Only non resource cats currently are for sessions so we take out those
                fn($arg) => !$this->lessonCategoryService->isSessionTypeCategory($arg) && $arg
            );
        }
        if (!$categories) {
            echo "ooops an error";
        }
        if (!$collection) {
            $collection = get_posts([
                'post_type' => 'sfwd-lessons',
                'posts_per_page' => 25,
                'order' => 'DESC',
                'orderby' => 'date',
                'post_status' => 'publish',
                'meta_query' => [
                    [
                        'key' => 'course_id',
                        'value' => $programId,
                    ],
                ]
            ]);
        }

        $post = get_post($programId);
    ?>
        <div class="lolole-section">
            <header>
                <div class="section-header-flex-row section-title-wrapper">
                    <div class="section-title">
                        <h2>
                            <?= $title ?>
                        </h2>
                    </div>

                </div>
                <?php if ($post->post_excerpt): ?>
                    <p class="section-description"><?= $post->post_excerpt; ?></p>
                <?php endif; ?>
            </header>

            <div style="gap:36px; display:flex; flex-direction:column; justify-content:space-between;">
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
                        <div class="right">
                            <a href="<?= get_the_permalink($programId); ?>" class="view-all-button">View All</a>
                        </div>
                    </div>
                    <div class="embla__viewport">
                        <div class="embla__container" <?php if ($slideWidth): ?>style="--slide-size:<?= $slideWidth; ?>;" <?php endif; ?>>
                            <?php foreach ($categories as $item) { ?>
                                <?php $categoryCardCB($item, $programId); ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
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

                        <div>
                            <h3 class="section__subtitle">
                                Most Recent
                            </h3>
                        </div>

                        <div class="right">
                            <a href="<?= get_the_permalink($programId); ?>" class="view-all-button">View All</a>
                        </div>
                    </div>

                    <div class="embla__viewport">
                        <div class="embla__container">
                            <?php foreach ($collection as $item) { ?>
                                <?= $collectionCardCB($item, $programId); ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <a href="<?= get_the_permalink($programId); ?>" class="view-all-button">View All</a>
            </footer>
        </div>
    <?php
    }

    protected function resourceCard(\WP_Post $post): void {
        (new \JP\Card\ResourceCard($post))->render();
    }

    /**
     * @param string $title
     * @param callable $cardCB
     * @param WP_Term $term
     * @return void
     */
    public function renderTagCloudSection(
        string $title,
        callable $cardCB,
        WP_Term $term,
    ): void {

        $catgoryService = new \JP\LessonCategoryService();
        $description = $catgoryService->description($term);
        $archiveLink = get_term_link($term);

        $collection = get_posts([
            'post_type' => 'sfwd-lessons',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'date',
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => 'ld_lesson_category',
                    'field' => 'slug',
                    'terms' => [
                        $term->slug,
                    ],
                ],
            ]

        ]);
    ?>
        <div class="lolole-section">
            <header>
                <div class="section-header-flex-row section-title-wrapper">
                    <div class="section-title">
                        <h2>
                            <?= $title ?>
                        </h2>
                    </div>

                    <div>
                        <div class="right">
                            <a href="<?= $archiveLink; ?>" class="view-all-button">View All</a>
                        </div>
                    </div>
                </div>

                <?php if ($description): ?>
                    <p class="section-description"><?= $description; ?></p>
                <?php endif; ?>
            </header>

            <div>

                <div class="lolole-tag-cloud">
                    <?php foreach ($collection as $item) { ?>
                        <?= $cardCB($item); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php
    }

    public function toolTag(\WP_Post $post): void {
        // TODO: Implement a way to get the icon for the tool.
        // $icon = dumpSvg("close");
    ?>
        <a href="<?= get_permalink($post->ID); ?>" class="tagCloud__tag aim-card">
            <h4 href="<?= get_the_permalink($post->ID); ?>" class="tagCloud__tag-link">
                <?= $post->post_title; ?>
            </h4>
        </a>
<?php
    }
}
