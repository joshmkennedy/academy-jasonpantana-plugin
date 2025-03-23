<?php

namespace JP;

use WP_Post;

class IconCardNav {


    /**
     * @param array<mixed> $collection 
     * @param IconCardPropertyAccessorInterface $propertyAccessor;
     * @return void 
     */
    public function __construct(
        public array $collection,
        public IconCardPropertyAccessorInterface $propertyAccessor,
    ) {
    }

    /**
     * @param ?array<string> $slugs 
     * @return void 
     */
    public function enqueueAssets(?array $slugs = []): void {
        enqueueAsset('icon-card-nav');
        foreach ($slugs as $slug) {
            enqueueAsset($slug);
        }
    }

    public function render(): void {
        if (!count($this->collection)) return;
?>
        <div>
            <div class="icon-card-nav embla">
                <button class="embla__button--prev embla__button">
                    <?= dumpSvg('chevron-left'); ?>
                </button>
                <div class="embla__viewport">
                    <div class="embla__container">
                        <?php foreach ($this->collection as $item) {
                            $link = $this->propertyAccessor->getItemLink($item);
                            $icon = $this->propertyAccessor->getItemIcon($item);
                            $color = $this->propertyAccessor->getItemColor($item);
                            $title = $this->propertyAccessor->getItemTitle($item);
                        ?>
                            <div class="embla__slide aim-card icon-card" style="--color:<?= $color; ?>;">
                                <div class="icon-card__contents">
                                    <a href="<?= $link; ?>" class="icon-card__thumb" title="<?= $title; ?>">
                                        <?= $icon; ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <button class="embla__button--next embla__button">
                    <?= dumpSvg('chevron-right'); ?>
                </button>
            </div>
        </div>
<?php
    }
}
