<?php

add_filter('template_include', function ($template) {
    $jpt = new \JP\JPTemplate();
    if (is_page("profile") && $t = $jpt->useTemplate('profile')) {
        enqueueAsset('aim-template');
        $template = $t;
    }
    return $template;
}, 10, 1);
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
    if (strpos($_SERVER['REQUEST_URI'], 'elementor') !== false) {
        return;
    }

    ob_start();
    $mainSection = new \JP\Profile\MainSection();
    $mainSection->render();

    return ob_get_clean();
});

add_action("wp", function () {
    if (!is_page('profile')) {
        return;
    }
    protect_paid_content(true);
});

add_shortcode('aim_profile_lololes__main', function () {
    if (strpos($_SERVER['REQUEST_URI'], 'elementor') !== false) {
        return;
    }

    ob_start();

    $mainSection = new \JP\Profile\MainSection();
    $mainSection->render();

    return ob_get_clean();
});
add_shortcode('aim_profile_lololes__secondary', function () {
    if (strpos($_SERVER['REQUEST_URI'], 'elementor') !== false) {
        return;
    }

    ob_start();
    $secondarySection = new \JP\Profile\SecondarySection();
    $secondarySection->render();

    return ob_get_clean();
});

add_shortcode('aim_profile_hero', function () {
    ob_start();
    $hero = new \JP\Profile\Hero();
    $hero->render();
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

add_action("wp_head", function () {
    if (!is_page('profile')) return;
    if (get_user_meta(get_current_user_id(), 'dismissed_fb_group', true)) return;
?>
    <style>
        .jp-fb-banner {
            background-color: var(--brand-c-primary);
            padding: 10px;
            padding-inline: 20px;
        }

        .jp-fb-banner .flex-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .jp-fb-banner__inner {
            max-width: var(----global-content-width);
            margin: 0 auto;
        }

        .jp-fb-banner__inner p {
            font-weight: bold;
            margin: 0 !important;
        }

        .jp-fb-banner__inner a {
            display: inline-block;
            background: var(--brand-c-dark);
            color: white;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;

            &:hover {
                text-decoration: none;
            }
        }

        .jp-fb-banner.hide {
            display: none;
        }

        #close-fb-banner {
            background: none;
            border: none;
            font-size: 12px;
            color: var(--brand-c-dark);
            cursor: pointer;

            &:hover {
                color: white;
            }
        }
    </style>
    <script>
        window.showFBanner = true
    </script>
<?php });
