<?php
add_filter('template_include', function ($template) {
    $jpt = new \JP\JPTemplate();
    if ($jpt->onArchive(['taxonomy' => 'ld_lesson_category']) && $t = $jpt->useTemplate('lesson-cat-archive')) {
        enqueueAsset('aim-template');
        $template = $t;
    }
    return $template;
}, 10, 1);

// PROTECT THEM
add_action('template_redirect', function () {
    $post = get_post();
    if ($post && ($post->post_type === 'sfwd-lessons')) {
        $userId = get_current_user_id();
        $groups = array_filter(\learndash_get_users_group_ids($userId), fn($id) => isPaidGroup($id));
        if (!count($groups)) {
            wp_redirect(wp_login_url());
            exit;
        }
    }
}, 10, 1);
