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
});

function jp_usersbyemail(WP_REST_Request $request): WP_REST_Response {
    $body = json_decode($request->get_body());
    $emails = $body->emails;
    $users = [];
    foreach ($emails as $email) {
        $user = get_user_by('email', $email);
        if ($user) {
            $users[$email] = [$user->first_name, $user->last_name];
        }
    }

    return rest_ensure_response($users);
}
