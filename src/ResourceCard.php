<?php

namespace JP;

use WP_Post;

class ResourceCard {
    private LessonCategoryService $lessonCategoryService;
    public function __construct() {
        $this->lessonCategoryService = new LessonCategoryService();
    }

    public function render(WP_Post $post): void {

        $cats = $this->lessonCategoryService->getAllFor($post);
        $excerpt = $post->post_excerpt;
?>
        <div class="aim-card resource-card ">
            <div class="card-contents">
                <div class="meta">
                    <?php
                    if ($cats) {
                        foreach ($cats as $cat) {
                    ?>
                            <div class="meta-item">
                                <span class="meta-item-icon">
                                    <?= $this->lessonCategoryService->icon($cat); ?>
                                </span>
                                <span class="meta-item-label"><?= $this->lessonCategoryService->pluralLabel($cat); ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <h4 class="card-title">
                    <a href="<?= get_the_permalink($post->ID); ?>">
                        <?= get_the_title($post->ID); ?>
                    </a>
                </h4>
                <p class="excerpt"><?= $excerpt; ?></p>

                <a href="<?= get_the_permalink($post->ID); ?>" class="link">
                    View <?= $cats[0] ? $this->lessonCategoryService->singlularLabel($cats[0]) : 'Resource'; ?>
                </a>
            </div>
        </div>
<?php
    }
}
