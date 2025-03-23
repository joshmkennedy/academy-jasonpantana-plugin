<?php
get_header();
$tutil = new \JP\JPTemplate();
$card = new \JP\ResourceCard();
$queried = get_queried_object();
$catService = new \JP\LessonCategoryService();

// this is kinda dumb should probably be its own actual class
$categoryNav = new \JP\IconCardNav(
    //resources
    collection: $catService->getAll(fn($arg) => !\JP\LessonCategoryService::isSessionTypeCategory($arg)),
    // property accessor for terms
    propertyAccessor: new class implements \JP\IconCardPropertyAccessorInterface {
        public \JP\LessonCategoryService $catService;
        public function __construct() {
            $this->catService = new \JP\LessonCategoryService();
        }
        public function getItemLink(mixed $item): string {
            return get_term_link($item);
        }
        public function getItemIcon(mixed $item): string {
            return $this->catService->icon($item);
        }
        public function getItemColor(mixed $item): string {
            return $this->catService->color($item);
        }
        public function getItemTitle(mixed $item): string {
            return $item->name;
        }
    }
);
$categoryNav->enqueueAssets();
?>

<div class="lesson-cat-archive aim-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url('/wp-content/uploads/2025/03/Gradients-01.png');">
        <div class="aim-template-header__content">


            <h1 class="title">
                <span class="archive-type">Category</span>
                <span class="title-with-mark">
                    <span class="mark">
                        <?= \get_taxonomy_image($queried->term_id, true); ?>
                    </span>
                    <?php the_archive_title(); ?>
                </span>
            </h1>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <div class="aim-template-content__page">

            <?php $categoryNav->render(); ?>

            <?php if (have_posts()): ?>
                <div class="lesson-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <?php $card->render(get_post()); ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>


            <?php include $tutil->useTemplate('utils/pagination'); ?>
        </div>
    </div>
</div>

<?php
get_footer();
