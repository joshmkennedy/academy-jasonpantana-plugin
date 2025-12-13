<?php

/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */


?>

<div
    <?php echo get_block_wrapper_attributes(); ?>>

    <div
        class="snippet__embla-viewport">
        <div class="snippet__carousel-container">
            <?php foreach ($block->inner_blocks as $inner_block): ?>
                <?php echo $inner_block->render(); ?>
            <?php endforeach; ?>
        </div>
        <div class="snippet__carousel-navigation">
            <button class="embla__button embla__button--prev">
                <?= dumpSvg('chevron-left'); ?>
            </button>
            <button class="embla__button embla__button--next">
                <?= dumpSvg('chevron-right'); ?>
            </button>
        </div>
    </div>

</div>
