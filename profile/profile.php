<?php
// List of List of Lessons shortcode

add_shortcode('aim_profile_lololes', function () {
    $lolole = new Lolole();
    return $lolole->render();
});

add_action('wp_enqueue_scripts', function () {
    // profile and staging
    // TODO: delete staging
    if (!isurl('/profile') && !isurl('/profile-copy'))
        return;

    enqueueAsset('profile');
});

// ListofListofLessons ;)
class Lolole {
    public function __construct() {
    }

    public function render(): string {
        ob_start();
?>
        <div class="lolole-wrapper">
            <?php $this->renderSection(
                title: 'Sessions',
                programId: 55,
                cardCB: fn($args) => $this->sessionCard($args),
            ); ?>

            <?php $this->renderSection(
                title: 'Essentials',
                programId: 1294,
                cardCB: fn($args) => $this->essentialCard($args),
            ); ?>

            <?php $this->renderSection(
                title: 'Resources',
                programId: 1273,
                cardCB: fn($args) => $this->resourceCard($args),
            ); ?>
        </div>
    <?php
        return ob_get_clean();
    }

    private function essentialCard(\WP_Post $post): void {
        $videoUrl = VimeoUtils::firstEmbedUrl($post);
        $vimeoId = VimeoUtils::getId($videoUrl);
        $thumbUrl = VimeoUtils::getThumb($vimeoId);
    ?>
        <a href="<?= get_the_permalink($post->ID); ?>" class="embla__slide card essentials-card " style="--bg-image: url('<?= $thumbUrl; ?>');">
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
    private function sessionCard(\WP_Post $post): void {
        $title = get_the_title($post->ID);
        $link = get_the_permalink($post->ID);

        $date = get_field("session_date", $post->ID) ?: get_the_date('F', $post->ID);

        $sessionType = $this->sessionType($post);
        $icon = $this->sessionTypeIcon($sessionType);
        $color = $this->sessionTypeColor($sessionType);
        $thumbUrl = $this->getSessionThumb($post, $sessionType);

    ?>

        <div class="embla__slide card session-card " style="--type-color: <?= $color; ?>;">
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

                <?php if ($sessionType && $sessionType->slug == 'session-lab'): ?>
                    <div class="sessionAction">
                        <a href="<?= $link; ?>">
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

    private function resourceCard(\WP_Post $post): void {
        $cats = $this->lessonCats($post);  /* 😽 */
        $excerpt = $post->post_excerpt;
    ?>
        <div class="embla__slide card resource-card ">
            <div class="card-contents">
                <div class="meta">
                    <?php
                    if ($cats) {
                        foreach ($cats as $cat) {
                    ?>
                            <div class="meta-item">
                                <span class="meta-item-icon">
                                    <?php echo get_taxonomy_image($cat->term_id, true); ?>
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

    private function renderSection(string $title, int $programId, callable $cardCB): void {
        $lessons = learndash_get_lesson_list($programId, ['num' => 25]);
        $post = get_post($programId);
    ?>
        <div class="lolole-section">
            <header>
                <div class="section-header-flex-row">
                    <div class="section-title">
                        <span class="mark">
                            <img src="<?= getAimAssetUrl('gradient-mark.avif'); ?>" />
                        </span>
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
                    <div class="embla__dots">
                    </div>
                </div>
                <div class="embla__viewport">
                    <div class="embla__container">
                        <?php foreach ($lessons as $lesson) { ?>
                            <?= $cardCB($lesson); ?>
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
     * 😽
     * @param WP_Post $post
     * @return \WP_Term[]|false
     */
    private function lessonCats(\WP_Post $post): array|false {
        $cats = get_the_terms($post->ID, 'ld_lesson_category');
        if (!$cats || count($cats) <= 0)
            return false;
        return $cats;
    }

    private function sessionType(\WP_Post $post): \WP_Term|false {
        $isSessionType = fn(\WP_Term|false $term) => $term && str_starts_with($term->slug, 'session-');
        $cats = $this->lessonCats($post);
        error_log(print_r($cats, true));
        if (!$cats) return false;

        $sessionTypes = array_filter($cats, $isSessionType);
        if (count($sessionTypes) <= 0) return false;
        return $sessionTypes[0];
    }

    private function sessionTypeIcon(\WP_Term|false $sessionType): string {
        if (!$sessionType)
            return '';
        return get_taxonomy_image($sessionType->term_id, true);
    }

    private function sessionTypeColor(\WP_Term|false $sessionType): string {
        if (!$sessionType)
            return 'var(--slate-800)';
        return get_field('color', $sessionType) ?: 'pink';  // remind to actually set this up
    }

    private function getSessionThumb(\WP_Post $post, \WP_Term|false $sessionType): string {
        if ($sessionType && $sessionType->slug != 'session-lab' && !has_post_thumbnail($post)) return ''; // TODO: make this a default image
        if ($sessionType && $sessionType->slug == 'session-lab') {
            $videoUrl = VimeoUtils::firstEmbedUrl($post);
            if (!$videoUrl) return has_post_thumbnail($post) ? get_the_post_thumbnail_url($post->ID, 'full') : '';
            $vimeoId = VimeoUtils::getId($videoUrl);
            $thumbUrl = VimeoUtils::getThumb($vimeoId);
            return $thumbUrl;
        }
        return get_the_post_thumbnail_url($post->ID, 'full');
    }
}
