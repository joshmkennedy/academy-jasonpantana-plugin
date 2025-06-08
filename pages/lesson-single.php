<?php
add_filter('template_include', function ($template) {
    $jpt = new \JP\JPTemplate();
    if ($jpt->onSingle(['post_type' => 'sfwd-lessons']) && $t = $jpt->useTemplate('single-sfwd-lessons')) {
        enqueueAsset('aim-template');
        $template = $t;
    }
    return $template;
}, 10, 1);
