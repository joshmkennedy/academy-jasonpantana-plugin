<?php

add_filter('template_include', function ($template) {
    $jpt = new \JP\JPTemplate();
    if (is_search() && $t = $jpt->useTemplate('search')) {
        enqueueAsset('aim-template');
        enqueueAsset('search');
        $template = $t;
    }
    return $template;
}, 10, 1);

add_filter("pre_get_posts", function (\WP_Query $query) {
    if (!$query->is_search || !$query->is_main_query() || $query->is_admin)
        return $query;

    $query->set('post_type', [
        'sfwd-lessons',
        'sfwd-courses',
    ]);
    return $query;
});
