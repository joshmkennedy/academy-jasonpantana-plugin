<?php

namespace JP\Card;

use JP\Lesson\BaseLesson;

class SearchResourcCard implements CardInterface {
    use SearchCardHeaderTrait;
    private BaseLesson $lesson;
    public function __construct(private \WP_Post $post) {
        $this->lesson = new BaseLesson($post);
    }

    public function render(): void {
        $cats = $this->lesson->categories();
        $type = get_post_type($this->post);
        $typelink = get_post_type_archive_link($type);

        if ($type === "sfwd-lessons") {
            $programId = learndash_get_course_id($this->post->ID);
            $type = get_post($programId)->post_title;
            $typelink = get_permalink($programId);
        }
?>
        <div>
            <?php $this->renderHeader($type, $typelink); ?>
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
        </div>
<?php

    }
}
