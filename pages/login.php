<?php


add_filter('template_include', function ($template) {
    $slugs = [
        "login",
        "reset-password",
        "registration",
        "choose-your-plan",
    ];
    $jpt = new \JP\JPTemplate();
    if (
        $jpt->onPage($slugs) &&
        $t = $jpt->useTemplate('auth-form')
    ) {
        enqueueAsset('auth-form');
        $template = $t;
    }
    return $template;
}, 10, 1);
