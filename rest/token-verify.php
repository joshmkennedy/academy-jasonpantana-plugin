<?php
add_action('rest_api_init', function () {
    register_rest_route('jp/v1', '/token-verify', [
        'methods' => 'POST',
        'callback' => '\JPTokenVerify::handler',
        'permission_callback' => function () {
            // Restrict who can use this endpoint as necessary
            // ONLY Admins can use this endpoint
            return current_user_can('manage_options');
        },
    ]);
});

class JPTokenVerify {
    public static function handler(WP_REST_Request $request): WP_REST_Response {
        $body = json_decode($request->get_body());

        if (empty($body->token)) {
            return new WP_REST_Response(
                ['error' => 'Token required'],
                400
            );
        }

        $result = \JP\AimAppToken::verifyToken($body->token);

        if (!$result) {
            return new WP_REST_Response(
                ['error' => 'Invalid or expired token'],
                401,
            );
        }

        $user = get_user_by('id', $result['user_id']);
        if (!$user) {
            return new WP_REST_Response(
                ['error' => 'User not found'],
                404
            );
        }

        // Return user data - customize as needed
        return rest_ensure_response([
            'valid' => true,
            'user' => [
                'id' => $user->ID,
                'email' => $user->user_email,
                'display_name' => $user->display_name,
                // Add other user meta as needed
            ],
        ]);
    }
}
