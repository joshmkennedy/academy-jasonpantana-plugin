<?php

add_action('rest_api_init', function () {
    register_rest_route('jp/v1', '/sync', array(
        'methods' => 'POST',
        'callback' => 'jp_sync',
        'permission_callback' => function () {
            // Restrict who can use this endpoint as necessary
            // For example, only logged-in users who can list users:
            return current_user_can('list_users');
        },

    ));
});

function jp_sync(WP_REST_Request $request): WP_REST_Response {
    // $perPage = $request->get_param('per_page');
    // $page = $request->get_param('page');

    return rest_ensure_response(['message' => 'ok']);
}

