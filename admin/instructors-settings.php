<?php

function jp_register_instructor_settings_page() {
    add_submenu_page(
        'jp-settings',
        'AiM Expert Settings',
        'AiM Expert Settings',
        'manage_options',
        'aim-instructor-settings',
        'jp_instructor_settings_page_html'
    );
}
add_action('admin_menu', 'jp_register_instructor_settings_page');

function jp_add_instructor_tags_menu(){
    add_submenu_page(
        'jp-settings',
        'AiM Expert In',
        'AiM Expert In',
        'manage_options',
        'edit-tags.php?taxonomy=expert-in-tag',
        null
    );
    add_submenu_page(
        'jp-settings',
        'AiM Expert With',
        'AiM Expert With',
        'manage_options',
        'edit-tags.php?taxonomy=expert-with-tag',
        null
    );
}

add_action('admin_menu', 'jp_add_instructor_tags_menu');

function jp_instructor_settings_page_html() {
    if ($_POST['jp_instructor_settings_nonce'] && wp_verify_nonce(sanitize_key($_POST['jp_instructor_settings_nonce']), 'jp_instructor_settings_save')) {
        $settings = [
            'heading' => sanitize_text_field($_POST['profile-widget-heading']),
            'tagline' => sanitize_text_field($_POST['profile-widget-tagline']),
            'view_all' => sanitize_text_field($_POST['profile-widget-view-all']),
        ];
        update_option('jp_instructor_settings', $settings);
        echo '<div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>';
    }
    $settings = get_option('jp_instructor_settings', [
        'heading' => "AiM Experts",
        "tagline" => "Book personalized one-on-one strategy sessions with our AI and marketing specialists.",
        'view_all' => "https://aimarketingacademy.as.me/",
    ]);
?>

    <style>
        .wrap h1 {
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            font-weight: 600;
        }

        .settings-form {
            max-width: 600px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .settings-form-option {
            margin-bottom: 1.75rem;
        }

        .settings-form-option:last-of-type {
            margin-bottom: 2rem;
        }

        .settings-form-option label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #1a1a1a;
            font-size: 0.95rem;
        }

        .settings-form-option input:not([type="submit"], [type="checkbox"], [type="radio"]),
        .settings-form-option textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d0d0d0;
            border-radius: 6px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .settings-form-option input[type="text"]:focus,
        .settings-form-option textarea:focus {
            outline: none;
            border-color: #2271b1;
            box-shadow: 0 0 0 3px rgba(34, 113, 177, 0.1);
        }

        .settings-form-option textarea {
            resize: vertical;
            min-height: 100px;
            line-height: 1.5;
        }

        .submit input {
            background: #2271b1;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .submit input:hover {
            background: #135e96;
            box-shadow: 0 2px 8px rgba(34, 113, 177, 0.2);
        }

        .submit input:active {
            transform: translateY(1px);
        }
    </style>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="" class="settings-form">
            <?php wp_nonce_field('jp_instructor_settings_save', 'jp_instructor_settings_nonce'); ?>
            <div class="settings-form-option">
                <label for"profile-widget-heading">Profile Widget Heading</label>
                <input type="text" name="profile-widget-heading" id="profile-widget-heading" style="width:300px" value="<?php echo $settings['heading']; ?>">
            </div>
            <div class="settings-form-option">
                <label for"profile-widget-tagline">Profile Widget Tagline</label>
                <textarea name="profile-widget-tagline" id="profile-widget-tagline"><?php echo $settings['tagline']; ?></textarea>
            </div>
            <div class="settings-form-option">
                <label for"profile-widget-view-all">View All Link</label>
                <input type="url" placeholder="https://url.com"  name="profile-widget-view-all" id="profile-widget-view-all" style="width:300px" value="<?php echo $settings['view_all']; ?>">
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}
