<?php
get_header();
$tutil = new \JP\JPTemplate;
$aimClipPage = new \JP\AimClipPage();
$clipInfo = $aimClipPage->getVimeoInfo();
$vimeoId = $aimClipPage->getVimeoId();
?>

<div class="aim-search-template aim-template aim-clip-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.webp'); ?>);">
        <div class="aim-template-header__content">
            <div class="title">
                <span>Clip from</span>
                <h1><?= $clipInfo['name']; ?></h1>
            </div>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <div class="aim-template-content__page">

            <div class="aim-template-content__page__video-container">
                <div class="wp-block-embed" data-aim-clip="<?= $vimeoId; ?>">
                    <iframe style="min-width:100%; aspect-ratio: 16/9;" src="<?= $clipInfo['player_embed_url']; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
get_footer();
