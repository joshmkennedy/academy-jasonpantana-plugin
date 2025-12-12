<?php
get_header();
$tutil = new \JP\JPTemplate;

?>

<div class=" aim-template aim-wide-template profile-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.webp'); ?>);">
        <div class="aim-template-header__content">

            <div class="title" style="text-align: left;">
                <h1>Welcome to Ai Marketing Academy</h1>
                <p>Here, you’ll find all your training materials conveniently organized</p>
            </div>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <?php if (user_can(wp_get_current_user(), 'edit_posts')): ?>
            <div class="aim-template-content__page">
                <?php echo do_shortcode('[aim_profile_hero]'); ?>
            </div>
        <?php endif; ?>
        <div class="aim-template-content__page">
            <?php echo do_shortcode('[aim_profile_lololes__main]'); ?>
        </div>
        <div class="aim-template-content__page">
            <?php echo do_shortcode('[aim_profile_lololes__secondary]'); ?>
        </div>

        <?php echo do_shortcode('[aim_search_banner]'); ?>
    </div>
</div>

<?php
get_footer();
