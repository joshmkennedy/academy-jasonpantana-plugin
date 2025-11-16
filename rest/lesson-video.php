
<?php
add_action('rest_api_init', function () {
    register_rest_route('jp/v1', '/lesson-video-url', array(
        'methods' => 'GET',
        'callback' => 'jp_lesson_video_url',
        'permission_callback' => function () {
            // Restrict who can use this endpoint as necessary
            // For example, only logged-in users who can list users:
            return current_user_can('edit_posts');
        },

    ));
});

function jp_lesson_video_url(WP_REST_Request $request): WP_REST_Response {
    $id = $request->get_param('id');
    $post = get_post((int)$id);
    if(get_post_type($post) !== 'sfwd-lessons'){
        return rest_ensure_response(['url'=>get_the_post_thumbnail_url($post->ID, 'full')]);
    }
    $lessonService = new \JP\LessonService();
    $thumbUrl = $lessonService->getThumbUrl($post);

    return rest_ensure_response(['url' => $thumbUrl]);
}

