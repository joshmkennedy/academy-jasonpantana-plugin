<?php

/**
 * Plugin Name:  Ai Marketing Academy
 * Version:      1.1.1
 **/

require_once __DIR__ . '/utils.php';

/*╭───────────────────────────╮*/
/*│    [   Course Grid   ]    │*/
/*╰───────────────────────────╯*/

// GRID STYLES
add_action('wp_enqueue_scripts', function () {
    // version is filetime 
    wp_enqueue_style('jp-style', plugins_url('styles.css', __FILE__), [], filemtime(plugin_dir_path(__FILE__) . 'styles.css'));
});
// ADD EXCERPT USED IN GRID CARDS
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
    $paidGroups = [1822, 1699];
    $userId = get_current_user_id();
    $groups = array_filter(learndash_get_users_group_ids($userId), fn($id) => in_array($id, $paidGroups));
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

add_action('user_register', function ($userId) {
    error_log(print_r(["POST" => $_POST, "GET" => $_GET], true));
    if (isset($_POST['ld_register_id']) && $_POST['ld_register_id']) {
        update_user_meta($userId, "initial_registered_ld_group", $_POST['ld_register_id']);
    }
}, 10, 1);

function getRegistrationURL($userId, $fallbackURL) {
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
