<?php
add_filter('template_include', function ($template) {
    $jpt = new \JP\JPTemplate();
    if ($jpt->onSingle(['post_type' => 'sfwd-courses']) && $t = $jpt->useTemplate('single-sfwd-courses')) {
        enqueueAsset('aim-template');
        $template = $t;
    }
    return $template;
}, 10, 1);
