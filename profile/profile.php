<?php
// List of List of Lessons shortcode

add_shortcode("aim_profile_lololes", function () {
    $lolole = new Lolole();
    return $lolole->render();
});

add_action('wp_enqueue_scripts', function () {
    if (!isurl("/profile")) return;

    enqueueAsset("profile");
});

class Lolole {
    public function __construct() {
    }

    public function render(): string {

        ob_start();
?>
        <div class="lolole-wrapper">
            <?php $this->renderSection(
                title: "Essentials",
                programId: 1294,
                cardCB: fn($args) => $this->essentialCard($args),
            ); ?>
            <?php $this->renderSection(
                title: "Sessions",
                programId: 55,
                cardCB: fn($args) => $this->resourceCard($args),
            ); ?>
            <?php $this->renderSection(
                title: "Resources",
                programId: 1273,
                cardCB: fn($args) => $this->resourceCard($args),
            ); ?>
        </div>
    <?php return ob_get_clean();
    }

    private function essentialCard(\WP_Post $post): void {
        $videoUrl = VimeoUtils::firstEmbedUrl($post);
        $vimeoId = VimeoUtils::getId($videoUrl);
        $thumbUrl = VimeoUtils::getThumb($vimeoId);
    ?>
        <a href="<?= get_the_permalink($post->ID); ?>" class="embla__slide card essentials-card " style="--bg-image: url('<?= $thumbUrl; ?>');">
            <h4 class="card-title" title="<?= get_the_title($post->ID); ?>">
                <span class="icon"><?= dumpSvg("play-circle"); ?></span>
                <span><?= get_the_title($post->ID); ?></span>
            </h4>

        </a>
    <?php
    }

    private function resourceCard(\WP_Post $post): void {
        $cats = $this->lessonCats($post);/*😽*/
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
                    <a href="<?= get_the_permalink($post->ID); ?>" >
                        <?= get_the_title($post->ID); ?>
                    </a>
                </h4>
                <p class="excerpt"><?= $excerpt; ?></p>

                <a href="<?= get_the_permalink($post->ID); ?>" class="link">
                    View <?= $cats[0]->name ?? "Resource"; ?>
                </a>
            </div>
        </div>
        </a>
    <?php
    }

    private function renderSection(string $title, int $programId, callable $cardCB): void {
        $lessons = learndash_get_lesson_list($programId, ['num' => 25]);

    ?>
        <div class="lolole-section">
            <div class="section-title">
                <span class="mark">
                    <img src="<?= getAimAssetUrl("gradient-mark.avif"); ?>" />
                </span>
                <h2>
                    <?= $title ?>
                </h2>
            </div>

            <div class="lolole-slider embla">
                <div class="lolole__controls">
                    <div class="embla__buttons">
                        <button class="embla__button--prev embla__button">
                            <?= dumpSvg("chevron-left"); ?>
                        </button>
                        <button class="embla__button--next embla__button">
                            <?= dumpSvg("chevron-right"); ?>
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
        </div>
<?php
    }

    /**
     * @param WP_Post $post 
     * @return \WP_Term[]|false
     */
    private function lessonCats(\WP_Post $post): array|false {
        $cats = get_the_terms($post->ID, 'ld_lesson_category');
        return $cats;
    }
}
