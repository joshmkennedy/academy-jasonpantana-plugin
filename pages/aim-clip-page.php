<?php

// create a new url param to check if we should redirect to the clip page
$aimClipPage = new \JP\AimClipPage();
add_filter('query_vars', function ($vars) use ($aimClipPage) {
    $vars = $aimClipPage->addVars($vars);
    return $vars;
});



add_action('init', function () use ($aimClipPage) {
    // add_rewrite_tag('%aim-clip%', '([^&]+)');
    // add_rewrite_rule('^aim-clip/([^/]+)/?$', 'index.php?aim-clip=$matches[1]', 'top');

    add_rewrite_tag('%aim-learning-path%', '([^&]+)');
    add_rewrite_rule('^aim-learning-path/([^/]+)/([^/]+)/?$', 'index.php?aim-learning-path=$matches[1]&week-index=$matches[2]', 'top');
});

add_action('wp', function () {
    if (
        // (get_query_var('aim-clip') != false && get_query_var('aim-clip') != '') || 
        (
            (get_query_var('aim-learning-path') != false && get_query_var('aim-learning-path') != '') &&
            (get_query_var('week-index') != false && get_query_var('week-index') != '')
        )

    ) {
        protect_paid_content(true);
    }
});

add_action('template_redirect', function () {
    $jpt = new \JP\JPTemplate();
    if (/*get_query_var('aim-clip') == false &&*/get_query_var('aim-learning-path') == false) {
        return;
    }



    // if (get_query_var('aim-clip') && $t = $jpt->useTemplate('aim-clip-page')) {
    //     $template = $t;
    // }

    if (get_query_var('aim-learning-path') && $t = $jpt->useTemplate('aim-learning-path-page')) {

        // this is used on both
        $handle = enqueueAsset('aim-template');
        global $getAimClipListWeekData;
        if (isset($getAimClipListWeekData)) {
            $id = get_query_var('aim-learning-path');
            $week = get_query_var('week-index');
            $week = str_replace('week_', '', $week);

            $weekData = $getAimClipListWeekData((int)$id, (int)$week);
            $data = $weekData->getVimeoPluginData();
            wp_localize_script($handle, 'aimVimeoPluginData', [
                'AimClipPlayerData' => $data
            ]);
        }

        include $t;
        exit;
    }

}, 100, 1);
