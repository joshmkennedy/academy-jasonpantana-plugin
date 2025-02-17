<?php

/**
 * Plugin Name:  Ai Marketing Academy
 **/

//$filepath = apply_filters( 'learndash_template', $filepath, $name, $args, $echo, $return_file_path );
// add_filter("learndash_template", function ($filepath, $name, $args, $echo, $return_file_path) {
//     if ($name == 'lesson/partials/row.php') {
//         // error_log(print_r($filepath,true));
//         $filepath = dirname(__FILE__) . '/course-content.php';
//     }
//     return $filepath;
// }, 10, 5);


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('jp-style', plugins_url('styles.css', __FILE__));
});

function enable_excerpt_on_custom_post_type() {
    add_post_type_support('sfwd-lessons', 'excerpt');
}
add_action('init', 'enable_excerpt_on_custom_post_type');

add_action('learndash-lesson-row-title-before', function ($lesson_id, $course_id, $user_id) {
    $cats = get_the_terms($lesson_id, 'ld_lesson_category');
    if ($cats && is_array($cats) && count($cats) > 0) {
?>
        <div class="ld-item-category">
            <?php foreach ($cats as $cat) { ?>
                <div class="ld-item-category-item">
                    <span class="ld-item-category-item-icon">
                        <?php echo get_taxonomy_image($cat->term_id, true); ?>
                    </span>
                    <span class="ld-item-category-item-label"><?= $cat->name; ?></span>
                </div>
            <?php } ?>
        </div>
    <?php
    }
}, 10, 3);


add_action('learndash-lesson-row-attributes-before', function ($lesson_id, $course_id, $user_id) {
    $excerpt = get_post($lesson_id)->post_excerpt;
    ?>
    <p><?= $excerpt; ?></p>
    <?php
    $link = get_the_permalink($lesson_id);
    $courseNoun = str_replace("AiM", "", get_post($course_id)->post_title);
    // ensure singular
    $courseNoun = str_ends_with($courseNoun, "s") ? substr($courseNoun, 0, strlen($courseNoun) - 1) : $courseNoun;

    ?>
    <a href="<?= $link; ?>" class="button button-primary">
        View <?= $courseNoun ?>
    </a>
<?php
}, 10, 3);

/**
 * Fires after the lesson title.
 *
 * @since 3.0.0
 *
 * @param int $lesson_id Lesson ID.
 * @param int $course_id Course ID.
 * @param int $user_id   User ID.
 */
