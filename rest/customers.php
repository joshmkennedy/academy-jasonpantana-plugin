<?php

add_action('rest_api_init', function () {
    register_rest_route('jp/v1', '/customers', array(
        'methods' => 'GET',
        'callback' => 'jp_customers',
        'params' => [
            'per_page' => [
                'type' => 'integer',
                'default' => 10,
            ],
            'page' => [
                'type' => 'integer',
                'default' => 1,
            ],
            'modified_since' => [
                'type' => 'string',
                'default' => null,
            ],
        ],
        'permission_callback' => function () {
            // Restrict who can use this endpoint as necessary
            // For example, only logged-in users who can list users:
            return current_user_can('list_users');
        },

    ));
});

function jp_customers(WP_REST_Request $request): WP_REST_Response {
    $perPage = $request->get_param('per_page');
    $page = $request->get_param('page');
    $modified_since = $request->get_param('modified_since');
    $users = [];
    $args = [
        'number' => $perPage,
        'offset' => ($page - 1) * $perPage,
        'meta_query' => [
            [
                "key" => "ez3mS_capabilities",
                "value" => "a:1:{s:10:\"subscriber\";b:1;}",
            ],
        ],
        'orderby' => 'ID',
        'order' => 'ASC',
    ];

    if (isset($modified_since)) {
        $args['date_query'] = [
            [
                'column' => 'user_registered',
                'after' => $modified_since,
                'inclusive' => true,
            ],
        ];
    }

    $users = array_map(function (\WP_User $_user) {
        $user = [];
        $user['firstName'] = $_user->first_name ?? "unknown";
        $user['lastName'] = $_user->last_name ?? "unknown";
        $user['email'] = $_user->user_email ?? "unknown";
        $user['wp_id'] = $_user->ID;
        $user['dateCreated'] = $_user->user_registered;
        // $user['stripe_id'] = get_usermeta($_user->ID, 'stripe_connect_customer_id', true);
        $user['groups'] = getLearndashGroups($_user);
        $user['phone'] = get_user_meta($_user->ID, 'phone', true);
        return $user;
    }, get_users($args));

    return rest_ensure_response($users);
}
