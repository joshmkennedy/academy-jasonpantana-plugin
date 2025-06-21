<?php

namespace JP\Card;

use WP_Post;
use JP\Lesson\BaseLesson;

class ResourceCard implements CardInterface {
    private BaseLesson $lesson;
    public function __construct(private \WP_Post $post) {
        $this->lesson = new BaseLesson($post);
    }

    public function render(): void {
        $cats = $this->lesson->categories();
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
                                    <?= $cat['icon']; ?>
                                </span>
                                <span class="meta-item-label"><?= $cat['plural']; ?></span>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <h4 class="card-title">
                    <a href="<?= $this->lesson->link(); ?>">
                        <?= $this->lesson->title(); ?>
                    </a>
                </h4>
                <p class="excerpt"><?= $this->lesson->excerpt(); ?></p>

                <a href="<?= $this->lesson->link(); ?>" class="link">
                    View <?= ($cats && $cats[0]) ? $cats[0]['singular'] : 'Resource'; ?>
                </a>
            </div>
        </div>
<?php
    }
}
