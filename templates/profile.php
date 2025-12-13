<?php
get_header();
$tutil = new \JP\JPTemplate;

?>

<div class=" aim-template aim-wide-template profile-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.webp'); ?>);">
        <div class="aim-template-header__content">

            <?php
            $walktrhoughBanner = new \JP\WalkthroughBanner();
            echo $walktrhoughBanner->render();
            ?>
            <div class="title" style="text-align: left;">
                <h1>Welcome to Ai Marketing Academy</h1>
                <p>Here, you’ll find all your training materials conveniently organized</p>
            </div>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <?php if (feature_flag('instuctors')): ?>
            <div class="aim-template-content__page">
                <?php
                $hero = new \JP\Profile\Hero();
                echo $hero->render();
                ?>
            </div>
        <?php endif; ?>
        <div class="aim-template-content__page">
            <?php
            $mainSection = new \JP\Profile\MainSection();
            echo $mainSection->render();
            ?>
        </div>
        <div class="aim-template-content__page">
            <?php
            $secondarySection = new \JP\Profile\SecondarySection();
            echo $secondarySection->render();
            ?>
        </div>

        <?php
        $searchBanner = new \JP\Search\SearchBanner();
        echo $searchBanner->render();
        ?>
    </div>
</div>

<?php
get_footer();
