<?php
get_header();
$tutil = new \JP\JPTemplate;
$queried = get_queried_object();

?>

<div class="aim-search-template aim-template aim-wide-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.webp'); ?>);">
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

            <?php include $tutil->useTemplate('utils/search-results-grid'); ?>

            <?php include $tutil->useTemplate('utils/pagination'); ?>
        </div>
    </div>
</div>

<?php
get_footer();
