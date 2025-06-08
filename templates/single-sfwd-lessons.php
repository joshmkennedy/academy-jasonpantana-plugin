<?php
get_header();
$tutil = new \JP\JPTemplate;

$programId = learndash_get_course_id(get_the_ID());
$program = get_post($programId);
$lessonCategoryService = new \JP\LessonCategoryService();
$categoryName = null;
if (get_post()) {
    $category = $lessonCategoryService->getAllFor(get_post());
    if ($category[0]) {
        $categoryName = $lessonCategoryService->singlularLabel($category[0]);
    }
}



?>

<div class="aim-lesson-single single-sfwd-courses aim-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.png'); ?>);">
        <div class="aim-template-header__content">

            <div class="title">
                <?php if ($categoryName): ?>
                    <span class="archive-type">
                        <?= $categoryName   ?>
                    </span>
                <?php endif; ?>
                <span class="title-with-mark">
                    <h1><?php the_title(); ?></h1>
                </span>
                <?php if ($program): ?>
                    <span class="archive-type" style="font-size:12px">
                        <?= $program->post_title;  ?>
                    </span>
                <?php endif; ?>
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
    </div>
</div>

<?php
get_footer();
