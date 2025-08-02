<?php
get_header();
$tutil = new \JP\JPTemplate;
$queried = get_queried_object();
$catService = new \JP\LessonCategoryService;
$searchBanner = new \JP\Search\SearchBanner;

/**
 * @var \JP\IconCardNav $categoryNavigation a slider of resource category icon cards
 **/
$categoryNavigation = new \JP\IconCardNav(
    //resources only for now
    collection: $catService->getAll(fn($arg) => !\JP\LessonCategoryService::isSessionTypeCategory($arg)),
    // property accessor for terms
    propertyAccessor: new \JP\LessonCategoryNavCardAccessor,
);
$categoryNavigation->enqueueAssets();
?>

<div class="lesson-cat-archive aim-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.webp'); ?>);">
        <div class="aim-template-header__content">

            <div class="title">
                <span class="mark">
                    <?= $catService->icon(get_term($queried->term_id)); ?>
                </span>
                <span class="title-with-mark">
                    <h1><?php the_archive_title(); ?></h1>
                </span>
                <span class="archive-type">Resources</span>
            </div>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <div class="aim-template-content__page">
            <p class="catnavigation-label">Categories</p>
            <?php $categoryNavigation->render(); ?>

            <?php if (have_posts()): ?>
                <div class="lesson-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <?php (new \JP\Card\ResourceCard(get_post()))->render(); ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>


            <?php include $tutil->useTemplate('utils/pagination'); ?>
        </div>
        <div style="max-width:var(--global-content-width); margin:0 auto;">
            <?= $searchBanner->render(); ?>
        </div>
    </div>


</div>

<?php
get_footer();
