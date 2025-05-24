<?php
add_action('wp_enqueue_scripts', function () {
    // profile and staging
    // TODO: delete staging
    if (!isurl('/profile') && !isurl('/profile-copy'))
        return;

    enqueueAsset('profile');
});

// List of List of Lessons shortcode
add_shortcode('aim_profile_lololes', function () {
    $lolole = new \JP\Lolole();
    return $lolole->render();
});

add_shortcode('aim_walkthrough_banner', function ($atts) {
	$walktrhoughBanner = new \JP\WalkthroughBanner();
	return $walktrhoughBanner->render($atts);
});


// ListofListofLessons ;)
