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
        <?php (new Hero())->render(); ?>


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

}
