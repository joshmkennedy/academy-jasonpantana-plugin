<?php

/**
 * Plugin Name:  Ai Marketing Academy
 * Version:      1.2.2
 **/
define('JP_PLUGIN_ROOT_DIR_PATH', plugin_dir_path(__FILE__));
define('JP_PLUGIN_ROOT_DIR_URL', plugin_dir_url(__FILE__));

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/utils.php';
// custom rest endpoint
require_once __DIR__ . '/rest/routes.php';

/*╭───────────────────────────╮*/
/*│    [   Course Grid   ]    │*/
/*╰───────────────────────────╯*/

try {
    // GRID STYLES
    add_action('wp_enqueue_scripts', function () {
        // version is filetime 
        wp_enqueue_style('jp-style', getAimAssetUrl('styles.css'), [], filemtime(getAimAssetPath('styles.css')));

        enqueueAsset('global');
    });

    // ADD EXCERPT USED IN GRID CARDS
    function enable_excerpt_on_custom_post_type(): void {
        add_post_type_support('sfwd-lessons', 'excerpt');
        add_post_type_support('sfwd-courses', 'excerpt');
    }
    add_action('init', 'enable_excerpt_on_custom_post_type');


    add_action('init', function () {
        $courses = get_post_types(['name' => 'sfwd-courses'], 'objects');
        if (isset($courses['sfwd-courses'])) {
            $courses['sfwd-courses']->rewrite['slug'] = 'aim';
            register_post_type('sfwd-courses', (array)$courses['sfwd-courses']);
        }
    }, 10, 99999999999);


    add_action('learndash-lesson-row-title-before', function ($lesson_id) {
        $LessonCategoryService = new \JP\LessonCategoryService;
        $cats = $LessonCategoryService->getAllFor(get_post($lesson_id));
        if ($cats && is_array($cats) && count($cats)) {
?>
            <div class="ld-item-category">
                <?php foreach ($cats as $cat) { ?>
                    <div class="ld-item-category-item">
                        <span class="ld-item-category-item-icon">
                            <?php echo get_taxonomy_image($cat->term_id, true); ?>
                        </span>
                        <span class="ld-item-category-item-label"><?= (new \JP\LessonCategoryService())->pluralLabel($cat); ?></span>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
    }, 10, 3);


    add_action('learndash-lesson-row-attributes-before', function ($lesson_id, $course_id) {
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

    require_once __DIR__ . '/acf/index.php';

    // ENSURES FONTS ARE LOADED
    add_action('wp_head', function () {
    ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <?php
    });


    /*╭────────────────────────────────────╮*/
    /*│    [   Join or Login Button   ]    │*/
    /*╰────────────────────────────────────╯*/

    add_shortcode('join_or_profile_button', function () {
        $url = getCurrentURL();
        $registration = "registration/";
        if (strpos($url, $registration) != false) {
            error_log("should hide");
            return null;
        }
        $userId = get_current_user_id();
        $groups = array_filter(learndash_get_users_group_ids($userId), fn($id) => isPaidGroup($id));
        $link = ($userId > 0) ? (
            count($groups) ? "/profile" : getRegistrationURL($userId, "/choose-your-plan")
        ) : "/choose-your-plan/";
        $buttonText = $userId > 0 ? (
            count($groups) ? "My Profile" : "Finish Account Setup"
        ) : "Join Now";
        ob_start(); ?>
        <div class="header-button-wrap">
            <div class="header-button-inner-wrap">
                <a href="<?= $link; ?>" target="_self" class="button header-button button-size-custom button-style-filled button-style-gradient--primary" style="padding-block:16px;">
                    <?= $buttonText; ?>
                </a>
            </div>
        </div>

<?php return ob_get_clean();
    });

    // add_action('learndash_course_lessons_order', function ($args, $courseId) {
    //     if(!$courseId !== 1273 || ) return $args;
    // }, 10, 2);


    add_action('user_register', function ($userId) {
        if (isset($_POST['ld_register_id']) && $_POST['ld_register_id']) {
            update_user_meta($userId, "initial_registered_ld_group", $_POST['ld_register_id']);
        }
    }, 10, 1);

    function getRegistrationURL(int $userId, string $fallbackURL): string {
        if (!$userId) return $fallbackURL;

        $groupId = get_user_meta($userId, "initial_registered_ld_group", true);
        if (!$groupId) return $fallbackURL;

        return site_url("registration/?ld-registered=true&ld_register_id=$groupId");
    }

    add_filter('wp_mail_from', function ($from) {
        if (strpos($from, 'wordpress') !== false) {
            return 'info@academy.jasonpantana.com';
        }
        return $from;
    },  99, 1);

    add_filter('wp_mail_from_name', function (string $from_name) {
        if (strpos(strtolower($from_name), 'wordpress') !== false) {
            return 'Jason Pantana and Ai Marketing Academy';
        }
        return $from_name;
    }, 99, 1);

    /**
     * Disable Admin Notification of User Password Change
     *
     * @see pluggable.php
     */
    if (! function_exists('wp_password_change_notification')) {
        function wp_password_change_notification($user) {
            return;
        }
    }

    // PUBLIC TEMPLATES AND PAGES
    require_once __DIR__ . '/pages/profile.php';
    require_once __DIR__ . '/pages/lesson-category.php';
    require_once __DIR__ . '/pages/lesson-single.php';
    require_once __DIR__ . '/pages/course-single.php';
    require_once __DIR__ . '/pages/registration-form.php';
    require_once __DIR__ . '/pages/search.php';
    //ADMIN
    require_once __DIR__ . '/admin/jp-settings.php';
    require_once __DIR__ . '/admin/lesson-admin-columns.php';
} catch (Exception $e) {
    error_log($e->getMessage());
}


register_meta(
    'post',
    'aim_tool_url', // Your meta key
    array(
        'show_in_rest'      => true, // Required
        'single'            => true, // Required
        'type'              => 'string',
        'sanitize_callback' => 'wp_strip_all_tags' // The name of the sanitization function
    )
);

register_meta(
    'post',
    'aim_tool_icon', // Your meta key
    array(
        'show_in_rest'      => true, // Required
        'single'            => true, // Required
        'type'              => 'string',
        'sanitize_callback' => 'wp_strip_all_tags' // The name of the sanitization function
    )
);

require __DIR__ . '/admin/protect-lesson.php';
