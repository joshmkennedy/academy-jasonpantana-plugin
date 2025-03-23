<?php

add_action('admin_init', function () {
    // register a new setting for "reading" page
    register_setting('general', 'jp_vimeo_api_key');
    // register a new section in the "reading" page
    add_settings_section(
        'aim_settings_section',
        'AIM Extra Settings',
        'aim_settings_section_callback',
        'general'
    );
    // register a new field in the "wporg_settings_section" section, inside the "reading" page
    add_settings_field(
        'aim_settings_field',
        'Vimeo API Token',
        'aim_api_field_callback',
        'general',
        'aim_settings_section'
    );
});

function aim_settings_section_callback(): void {
    echo '<h3>Vimeo</h3>';
}
function aim_api_field_callback(): void {
    $setting = get_option('jp_vimeo_api_key');
?>
    <input type="password" name="jp_vimeo_api_key" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
<?php

}
