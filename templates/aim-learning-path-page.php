<?php
get_header();
$tutil = new \JP\JPTemplate;
$aimClipPage = new \JP\AimClipPage();

$selectedVideo = $aimClipPage->getSelectedVideo();

?>

<div class="aim-search-template aim-template aim-clip-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.webp'); ?>);">
        <div class="aim-template-header__content">
            <div class="title">
                <span>This weeks Learning Path Content</span>
                <h1>
                    <!-- TODO: Week {week_index} -->
                    Week 1
                </h1>
            </div>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <div class="aim-template-content__page">
            
            <div class="aim-template-content__page__video-container aim-clip-player">
                <div class="wp-block-embed" data-aim-clip="<?= isset($selectedVideo['vimeoId']) ? $selectedVideo['vimeoId'] : ''; ?>" >
                    <iframe style="min-width:100%; aspect-ratio: 16/9;" src="<?= isset($selectedVideo['player_embed_url']) ? $selectedVideo['player_embed_url'] : 'https://player.vimeo.com/video/' . $selectedVideo['vimeoId']; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
