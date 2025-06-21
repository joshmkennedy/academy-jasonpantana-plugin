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
