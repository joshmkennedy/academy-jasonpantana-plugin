<?php

// create a new url param to check if we should redirect to the clip page
$learningPathSettings = new \JP\User\LearningPathSettings();
add_filter('query_vars', function ($vars) use ($learningPathSettings) {
    $vars = $learningPathSettings->addVars($vars);
    return $vars;
});

add_action('init', function () use ($learningPathSettings) {
    $learningPathSettings->rewriteRules();
});

add_action('template_redirect', function () use ($learningPathSettings) {
    $jpt = new \JP\JPTemplate();
    if (!$learningPathSettings->isOnPage()) {
        return;
    }
    enqueueAsset('user-settings');
    $handle = enqueueAsset('aim-template');
    include $jpt->useTemplate('learning-path-settings');
    exit;
}, 100, 1);
