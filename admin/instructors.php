<?php


function add_instructor_role() {
    add_role(
        'aim_instructors', // Unique ID for the role
        'AIM Instructor', // Display name for the role
        array(
            'read' => true, // Example capability: can read posts
            'edit_posts' => true, // Example capability: can edit their own posts
            // Add more capabilities as needed
        )
    );
}
add_action('init', 'add_instructor_role');

function add_user_profile_meta_box($user) {
    if(!is_user_logged_in()) return;
    if(!in_array('aim_instructors', $user->roles)) return;
    display_instructor_info_form($user);
}
add_action('show_user_profile', 'add_user_profile_meta_box', 0,1);
add_action('edit_user_profile', 'add_user_profile_meta_box',0,1);

function display_instructor_info_form($user) {
    $instructorRole = get_role('aim_instructors');
    $userData = get_userdata($user->ID);
    if (!in_array($instructorRole->name, $userData->roles)) {
        return;
    }
    include JP_PLUGIN_ROOT_DIR_PATH . "/templates/instructor-info-form.php";
}

function save_instructor_info_form($user_id) {
    $ud = get_userdata($user_id);
    error_log(print_r($ud,true));
    if(!in_array("aim_instructors", $ud->roles)) return;

    if (isset($_POST['instructor-speacialties-tags'])) {
        $tags = array_filter(array_map("trim",(explode(",",$_POST['instructor-speacialties-tags']))),fn($arg) => $arg!="");
        update_user_meta(
            $user_id,
            'instructor-speacialties-tags',
            $tags,
        );
    }
    if (isset($_POST['instructor-speacialties-ai-area-of-focus-description'])) {
        update_user_meta(
            $user_id,
            'instructor-speacialties-ai-area-of-focus-description',
            sanitize_textarea_field($_POST['instructor-speacialties-ai-area-of-focus-description']),
        );
    }
    if (isset($_POST['instructor-calendly-link'])) {
        update_user_meta(
            $user_id,
            'instructor-calendly-link',
            sanitize_url($_POST['instructor-calendly-link']),
        );
    }
    if (isset($_POST['instructor-is-available'])) {
        update_user_meta(
            $user_id,
            'instructor-is-available',
            '1',
        );
    } else {
        delete_user_meta($user_id, 'instructor-is-available');
    }
    if (isset($_POST['instructor-profile-img-id'])) {
        update_user_meta(
            $user_id,
            'instructor-profile-img-id',
            $_POST['instructor-profile-img-id'],
        );
    }
}
add_action( 'personal_options_update', 'save_instructor_info_form' );
add_action( 'edit_user_profile_update', 'save_instructor_info_form' );
