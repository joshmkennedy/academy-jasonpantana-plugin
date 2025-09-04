<?php

// create a new url param to check if we should redirect to the clip page
$aimClipPage = new \JP\AimClipPage();
add_filter('query_vars', function ($vars) use ($aimClipPage) {
    return $aimClipPage->addVars($vars);
});



add_action('init', function () use ($aimClipPage) {
    add_rewrite_tag('%aim-clip%', '([^&]+)');
    add_rewrite_rule('^aim-clip/([^/]+)/?$', 'index.php?aim-clip=$matches[1]', 'top');
});

add_action('wp', function () {
    if (get_query_var('aim-clip') != false && get_query_var('aim-clip') != '') {
        protect_paid_content(true);
    }
});

add_action('template_include', function ($template) {
    $jpt = new \JP\JPTemplate();
    if (get_query_var('aim-clip') == false || get_query_var('aim-clip') == '') {
        return $template;
    }

    if ($t = $jpt->useTemplate('aim-clip-page')) {
        enqueueAsset('aim-template');
        $template = $t;
    }
    return $template;
}, 100, 1);
