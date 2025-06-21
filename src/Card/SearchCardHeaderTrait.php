<?php

namespace JP\Card;

trait SearchCardHeaderTrait {
    public function renderHeader($typeOfCard, $typeLink): void {
?>
        <div class="searchcard-header__wrapper">
            <a href="<?= $typeLink; ?>" class="searchcard-header__link">
                <span class="searchcard-header__label">
                    <?= $typeOfCard; ?>
                </span>
            </a>
        </div>
<?php
    }
}
