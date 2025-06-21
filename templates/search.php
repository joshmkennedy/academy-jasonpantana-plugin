<?php
get_header();
$tutil = new \JP\JPTemplate;
$queried = get_queried_object();



global $wp_query;
$sections = [];
$sectionMeta = [];
if ($wp_query->is_search && $wp_query->is_main_query()) {
    foreach ($wp_query->posts as $post) {
        // skipping courses as these are going to be used as the groups
        if ($post->post_type === "sfwd-courses") continue;

        if (!isset($sections[$post->post_type])) {
            $sections[$post->post_type] = [];
            $postType = get_post_type_object($post->post_type);
            $sectionMeta[$post->post_type] = [
                'label' => $postType->label,
                'subsections' => [],
            ];
        }
        if ($post->post_type === "sfwd-lessons") {
            $programId = learndash_get_course_id($post->ID);
            if (!isset($sections[$post->post_type][$programId])) {
                $sections[$post->post_type][$programId] = [];
                $program = get_post($programId);
                $sectionMeta[$post->post_type]['subsections'][$programId] = [
                    'label' => $program->post_title,
                ];
            }
            $sections[$post->post_type][$programId][] = $post;
        } else {
            $sections[$post->post_type][] = $post;
        }
    }
}

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
            <?php if (isset($sectionMeta['sfwd-lessons'])): ?>
                <?php foreach ($sectionMeta['sfwd-lessons']['subsections'] as $programId => $subSectionMeta): ?>
                    <div class="section-group">
                        <header>
                            <div class="section-header-flex-row section-title-wrapper">
                                <div class="section-title">
                                    <h2><?= $subSectionMeta['label']; ?></h2>
                                </div>
                            </div>
                        </header>
                        <div class="lesson-grid">
                            <?php foreach ($sections['sfwd-lessons'][$programId] as $post): ?>
                                <?php $card = new \JP\LessonCard($post);
                                $card->render(); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php unset($sectionsMeta['sfwd-lessons']); ?>
            <?php endif; ?>
            <?php error_log(print_r($sectionMeta, true)); ?>
            <?php if (count($sectionMeta)): ?>
                <?php foreach ($sectionMeta as $sectionId => $sectionMeta): ?>
                    <div class="section-group">
                        <header>
                            <div class="section-header-flex-row section-title-wrapper">
                                <div class="section-title">
                                    <h2><?= $sectionMeta['label']; ?></h2>
                                </div>
                            </div>
                        </header>
                        <?php if (isset($sectionMeta['subsections']) && count($sectionMeta['subsections'])): ?>
                            <?php foreach ($sectionMeta['subsections'] as $subsectionId => $subsectionMeta): ?>
                                <header>
                                    <div class="section-header-flex-row section-title-wrapper">
                                        <div class="section-title">
                                            <h3><?= $subsectionMeta['label']; ?></h3>
                                        </div>
                                    </div>
                                </header>
                                <div class="lesson-grid">
                                    <?php foreach ($sections[$sectionId][$subsectionId] as $post): ?>
                                        <?php $card = new \JP\LessonCard($post);
                                        $card->render(); ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="lesson-grid">
                                <?php foreach ($sections[$sectionId] as $post): ?>
                                    <?php $card = new \JP\LessonCard($post);
                                    $card->render(); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php include $tutil->useTemplate('utils/pagination'); ?>
        </div>
    </div>
</div>

<?php
get_footer();
