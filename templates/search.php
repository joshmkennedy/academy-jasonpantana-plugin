<?php
get_header();
$tutil = new \JP\JPTemplate;
$queried = get_queried_object();

?>

<div class="aim-search-template aim-template aim-wide-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.png'); ?>);">
        <div class="aim-template-header__content">

            <div class="title">
                <span class="title-with-mark">
                    <h1>Searched for: <?= sanitize_text_field($_GET['s']); ?></h1>
                </span>
            </div>
            <?php
            get_search_form();
            ?>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <div class="aim-template-content__page">
            <!-- lessons -->

            <?php if (have_posts()): ?>
                <div class="lesson-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <?php $card = new \JP\SearchCard(get_post());
                        $card->render(); ?>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <h2>No results found</h2>
                    <p>Try searching for something else</p>
                </div>
            <?php endif; ?>

            <?php include $tutil->useTemplate('utils/pagination'); ?>
        </div>
    </div>
</div>

<?php
get_footer();
