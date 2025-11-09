<?php

namespace JP\Profile;


/** @package JP\Profile 
 *
 * @inheritdoc
 * */
class MainSection extends Lolole {
    public function __construct() {
        parent::__construct();
    }

    public function render(): void {
?>

        <div class="profile-user-notices">
            <?php $this->renderNotices([
                // banner for the assessment to sign up for the 100 days.
                fn() => (new \JP\Aim100daysModal())->renderNotice(),
            ]); ?>
        </div>

        <?php (new Instructors())->render(); ?>


        <div class="lolole-wrapper ">
            <?php $this->renderLessonsSection(
                title: 'Lectures',
                programId: 55,
                collection: get_posts([
                    'post_type' => 'sfwd-lessons',
                    'posts_per_page' => -1,
                    'order' => 'DESC',
                    'orderby' => 'date',
                    'post_status' => 'publish',
                    'meta_query' => [
                        [
                            'key' => 'course_id',
                            'value' => 55,
                        ],
                    ],
                    'tax_query' => [
                        [
                            'taxonomy' => 'ld_lesson_category',
                            'field' => 'slug',
                            'terms' => [
                                'session-lecture',
                            ],
                        ],
                    ]
                ]),
                cardCB: fn($args, $programId) => $this->sessionCard($args, $programId),
                description: get_term_by("slug", "session-lecture", "ld_lesson_category")->description,
            ); ?>

            <?php $this->renderLessonsSection(
                title: 'Labs',
                description: get_term_by("slug", "session-lab", 'ld_lesson_category')->description,
                programId: 55,
                collection: get_posts([
                    'post_type' => 'sfwd-lessons',
                    'posts_per_page' => -1,
                    'order' => 'DESC',
                    'orderby' => 'date',
                    'post_status' => 'publish',
                    'meta_query' => [
                        [
                            'key' => 'course_id',
                            'value' => 55,
                        ],
                    ],
                    'tax_query' => [
                        [
                            'taxonomy' => 'ld_lesson_category',
                            'field' => 'slug',
                            'terms' => [
                                'session-lab',
                            ],
                        ],
                    ]
                ]),
                cardCB: fn($args, $programId) => $this->sessionCard($args, $programId),
            ); ?>


            <?php
            $this->renderLessonCategorySection(
                title: 'Library',
                programId: 1273,
                categories: $this->resourceCatgories(),
                slideWidth: '166px',
                categoryCardCB: fn($args) => $this->resourceCategoryCard($args),
                collectionCardCB: fn($args) => $this->resourceCard($args),
            );
            ?>

        </div>
        <?php
    }

    public function renderNotices(array $banners): void {
        $max = 2;
        foreach ($banners as $bannerCB) {
            if ($max <= 0) break;

            $content = call_user_func($bannerCB);
            if (!$content) continue;
            $max--
        ?>
            <div class="profile-user-notice shimmer">
                <div class="contents shimmer">
                    <?= $content; ?>
                </div>
            </div>
<?php
        }
    }
}
