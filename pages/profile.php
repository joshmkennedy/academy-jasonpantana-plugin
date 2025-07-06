<?php
add_action('wp_enqueue_scripts', function () {
    // profile and staging
    if (!isurl('/profile') && !isurl('/profile-copy'))
        return;

    enqueueAsset('profile');
    wp_localize_script('jp-profile-script', 'AIM', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
    ]);
});

// List of List of Lessons shortcode
add_shortcode('aim_profile_lololes', function () {
    ob_start();
    $mainSection = new \JP\Profile\MainSection();
    $mainSection->render();

    return ob_get_clean();
});

add_shortcode('aim_profile_lololes__main', function () {
    ob_start();
    $mainSection = new \JP\Profile\MainSection();
    $mainSection->render();

    return ob_get_clean();
});
add_shortcode('aim_profile_lololes__secondary', function () {
    ob_start();
    $secondarySection = new \JP\Profile\SecondarySection();
    $secondarySection->render();

    return ob_get_clean();
});

add_shortcode('aim_walkthrough_banner', function ($atts) {
    $walktrhoughBanner = new \JP\WalkthroughBanner();
    return $walktrhoughBanner->render($atts);
});

add_action("wp_ajax_dissmiss_walkthrough_banner_perm", function () {
    $walktrhoughBanner = new \JP\WalkthroughBanner();
    $walktrhoughBanner->handleUserDismiss();
});

add_shortcode('aim_search_banner', function () {
    $searchBanner = new \JP\Search\SearchBanner();
    return $searchBanner->render();
});
