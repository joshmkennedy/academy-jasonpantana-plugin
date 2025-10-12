<?php
/**
 * Admin menu for JP plugin.
 *
 * @package JP
 */

/**
 * Register the main admin page.
 */
function jp_register_main_settings_page() {
    add_menu_page(
        'AIM Plugin Settings',
        'AIM Plugin Settings',
        'manage_options',
        'jp-settings',
        null, // No content for the main page itself, it will redirect to the first submenu.
        'dashicons-admin-generic',
        80
    );
}
add_action( 'admin_menu', 'jp_register_main_settings_page' );
