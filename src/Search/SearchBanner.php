<?php

namespace JP\Search;

class SearchBanner {
    private \JP\JPTemplate $tutil;
    public function __construct() {
        $this->tutil = new \JP\JPTemplate;
    }

    public function render(): string {
        ob_start();
?>

        <div class="aim-partial search-banner aim-search-template" style="--bg-image: url(<?= getAimAssetUrl('orange-gradient.avif'); ?>);">
            <div class="search-banner__content">
                <div class="search-banner__description">
                    <p class="large-heading">Can't find what you're looking for?</p>
                    <p>Search our library of resources and sessions</p>
                </div>

                <?php get_search_form(); ?>
            </div>
            <?php include $this->tutil->useTemplate('utils/circutry-graphic'); ?>
        </div>
<?php
        return ob_get_clean();
    }
}
