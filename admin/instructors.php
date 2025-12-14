<?php


function add_instructor_role() {
    add_role(
        'aim_instructors', // Unique ID for the role
        'AIM Instructor', // Display name for the role
        array(
            'read' => true, // Example capability: can read posts
            // Add more capabilities as needed
        )
    );
}
add_action('init', 'add_instructor_role');

function add_user_profile_meta_box($user) {
    if (!is_user_logged_in()) return;
    if (
        !in_array('aim_instructors', $user->roles)
        && !in_array('administrator', $user->roles)
    ) return;
    display_instructor_info_form($user);
}
add_action('show_user_profile', 'add_user_profile_meta_box', 0, 1);
add_action('edit_user_profile', 'add_user_profile_meta_box', 0, 1);

function enqueue_expert_tag_input_script() {
    $current_user = wp_get_current_user();
    // Enqueue on edit user profile pages for admin/aim-instructor users
    if (
        !in_array('aim_instructors', $current_user->roles)
        && !in_array('administrator', $current_user->roles)
    ) return;
    
    enqueueAsset('aim-expert-tag-input', true);
}
add_action('admin_enqueue_scripts', 'enqueue_expert_tag_input_script');

function display_instructor_info_form($user) {
    include JP_PLUGIN_ROOT_DIR_PATH . "/templates/instructor-info-form.php";
}

function save_instructor_info_form($user_id) {
    $ud = get_userdata($user_id);
    if (
        !in_array("aim_instructors", $ud->roles)
        && !in_array("administrator", $ud->roles)
    ) return;

    if (isset($_POST['users-expert-in-tag-tags'])) {
        $tags = json_decode(stripslashes($_POST['users-expert-in-tag-tags']), true);
        $updatedTags = [];
        foreach ((array)$tags as $tagId => $tagName) {
            if(!is_numeric($tagId)){
               $inserted = wp_insert_term($tagName, 'expert-in-tag');
               if(!is_wp_error($inserted)){
                   $updatedTags[] = $inserted['term_id'];
               }
            } else {
                $updatedTags[] = $tagId;
            }
        }
       $res = update_user_meta(
            $user_id,
            'expert-in-tags',
            $updatedTags,
        );
        if (!$res) {
            error_log("failed to update user meta");
        }
    }
    if (isset($_POST['users-expert-with-tag-tags'])) {
        $tags = json_decode(stripslashes($_POST['users-expert-with-tag-tags']), true);
        $updatedTags = [];
        foreach ((array)$tags as $tagId => $tagName) {
            if(!is_numeric($tagId)){
               $inserted = wp_insert_term($tagName, 'expert-with-tag');
               if(!is_wp_error($inserted)){
                   $updatedTags[] = $inserted['term_id'];
               }
            } else {
                $updatedTags[] = $tagId;
            }
        }
       $res = update_user_meta(
            $user_id,
            'expert-with-tags',
            $updatedTags,
        );
        if (!$res) {
            error_log("failed to update user meta");
        }
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
    if (isset($_POST['instructor-menu-order']) && is_numeric($_POST['instructor-menu-order'])) {
        update_user_meta(
            $user_id,
            'instructor-menu-order',
            (int)$_POST['instructor-menu-order'],
        );
    }
}
add_action('personal_options_update', 'save_instructor_info_form');
add_action('edit_user_profile_update', 'save_instructor_info_form');
