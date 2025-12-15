<?php
get_header();
$tutil = new \JP\JPTemplate;
$aimClipPage = new \JP\AimClipPage();

$selectedVideo = $aimClipPage->getSelectedVideo();

$weekIntro = $aimClipPage->getWeekIntro();
$week = get_query_var('week-index');
$weekIdx = str_replace('week_', '', $week);

?>

<div class="aim-search-template aim-template aim-clip-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.webp'); ?>);">
        <div class="aim-template-header__content">
            <a href="/profile" class="aim-template-header__content__back-link" style="color:white; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="max-width:1em;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back to Profile
            </a>
            <div class="title">
                <span>This Week’s AiM Lessons</span>
                <h1>
                    <!-- TODO: Week {week_index} -->
                    Week <?= $weekIdx ?>
                </h1>
            </div>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <div class="aim-template-content__page">
            <p class="header-description">
                <?= $weekIntro; ?>
            </p>

            <div class="aim-template-content__page__video-container aim-clip-player">
                <div class="wp-block-embed" data-aim-clip="<?= isset($selectedVideo['vimeoId']) ? $selectedVideo['vimeoId'] : ''; ?>">
                    <iframe style="min-width:100%; aspect-ratio: 16/9;" src="<?= isset($selectedVideo['player_embed_url']) ? $selectedVideo['player_embed_url'] : 'https://player.vimeo.com/video/' . $selectedVideo['vimeoId']; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
