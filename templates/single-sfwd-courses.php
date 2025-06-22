<?php
get_header();
$tutil = new \JP\JPTemplate;

$logo = file_get_contents(getAimAssetPath('aim.svg'));
$title = str_replace("AiM", "",  get_the_title());

$searchBanner = new \JP\Search\SearchBanner;

?>

<div class="aim-course-single aim-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.png'); ?>);">
        <div class="aim-template-header__content">
            <div class="title">
                <span class="mark">
                    <?= $logo; ?>
                </span>
                <span class="title-with-mark">
                    <h1><?= $title; ?></h1>
                </span>
            </div>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <div class="aim-template-content__page">

            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <div style="max-width:var(--global-content-width); margin:0 auto;">
            <?= $searchBanner->render(); ?>
        </div>
    </div>
</div>

<?php
get_footer();
