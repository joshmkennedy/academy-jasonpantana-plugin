<?php

// /wp-json/jp/v1/usersbyemail
add_action('rest_api_init', function () {
    register_rest_route('jp/v1', '/usersbyemail', array(
        'methods' => 'POST',
        'callback' => 'jp_usersbyemail',
        'permission_callback' => function () {
            // Restrict who can use this endpoint as necessary
            // For example, only logged-in users who can list users:
            return current_user_can('list_users');
        },
    ));
    register_rest_route('jp/v1', '/userbyemail', array(
        'methods' => 'GET',
        'callback' => 'jp_userbyemail',
        'args' => array(
            'email' => array(
                'required' => true,
                'type' => 'string',
            ),
        ),
        'permission_callback' => function () {
            // Restrict who can use this endpoint as necessary
            // For example, only logged-in users who can list users:
            return current_user_can('list_users');
        },
    ));
});

function jp_usersbyemail(WP_REST_Request $request): WP_REST_Response {
    $body = json_decode($request->get_body());
    $emails = $body->emails;
    $users = [];
    foreach ($emails as $email) {
        $user = get_user_by('email', $email);
        if ($user) {
            $learnDashGroup = getLearndashGroups($user);
            $phone = get_user_meta($user->ID, 'phone', true);
            $users[$email] = [$user->first_name, $user->last_name, $learnDashGroup, $phone];
        }
    }

    return rest_ensure_response($users);
}

function getLearndashGroups($user) {
    $groupIds = array_filter(\jp_learndash_get_users_group_ids($user->ID), fn($id) => isPaidGroup($id));
    $groupTitles =  array_map(fn($gid) => get_post($gid)?->post_title ?? "unknown", $groupIds);
    return implode(", ", $groupTitles);
}

function jp_userbyemail(WP_REST_Request $request): WP_REST_Response {
    $email = $request->get_param('email');
    $user = get_user_by('email', $email);
    if(!$user) {
        return rest_ensure_response("User not found", 404);
    }
    $learnDashGroup = getLearndashGroups($user);
    $phone = get_user_meta($user->ID, 'phone', true);
    return rest_ensure_response([
        'firstName'=>$user->first_name,
        'lastName'=>$user->last_name,
        'group'=>$learnDashGroup,
        'phone'=>$phone,
        'email'=>$user->user_email,
        'wp_id'=>$user->ID,
        'dateCreated'=>$user->user_registered,
    ]);
}
