<?php
get_header();
$tutil = new \JP\JPTemplate;

?>
<div class="aim-template single-form-page" style="--gradient-image:url(<?= getAimAssetUrl("green-gradient.webp"); ?>);">
    <div
        class="logo-header">
        <?= dumpSvg('aim'); ?>
    </div>
<?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    <div class="aim-template-content__page no-header">

        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
