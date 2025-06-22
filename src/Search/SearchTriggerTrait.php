<?php

namespace JP\Search;

trait SearchTriggerTrait {
    public function renderSearchTriggerWithText(array $classes = []): void {
?>
        <div class="search-trigger <?= implode(' ', $classes); ?>">
            <button class="search-trigger__button">
                <span class="search-trigger__icon"><?= dumpSvg('search'); ?></span>
                <span>Search</span>
            </button>
        </div>
<?php
    }

    public function renderSearchTriggerIcon(array $classes = []): void {
        ?>
        <div class="search-trigger <?= implode(' ', $classes); ?>">
            <button class="search-trigger__button">
                <span class="search-trigger__icon"><?= dumpSvg('search'); ?></span>
            </button>
        </div>
<?php
    }
}
