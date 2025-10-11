<?php

add_action('admin_init', function () {
    // register a new setting for "reading" page
    // every setting needs this or it wont be saved
    register_setting('general', 'jp_vimeo_api_key');
    register_setting('general', 'jp_stripe_api_key');
    register_setting('general', 'aim_form_100days_id');

    //setting section to group them all together
    add_settings_section(
        'aim_settings_section',
        'AIM Extra Settings',
        'aim_settings_section_callback',
        'general'
    );


    add_settings_field(
        'aim_vimeo_settings_field',
        'Vimeo API Token',
        'aim_vimeo_api_field_callback',
        'general',
        'aim_settings_section'
    );

    add_settings_field(
        'aim_stripe_settings_field',
        'Stripe API Token',
        'aim_stripe_api_field_callback',
        'general',
        'aim_settings_section'
    );

    add_settings_field(
        'jp_100days_form_id',
        'AIM 100 Days Form',
        'aim_100days_form_field_callback',
        'general',
        'aim_settings_section'
    );
});

function aim_settings_section_callback(): void {
    echo '<h3>Settings</h3>';
}


function aim_vimeo_api_field_callback(): void {
    $setting = get_option('jp_vimeo_api_key');
?>
    <input type="password" name="jp_vimeo_api_key" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
<?php

}

function aim_stripe_api_field_callback(): void {
    $setting = get_option('jp_stripe_api_key');
?>
    <input type="password" name="jp_stripe_api_key" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
<?php

}

function aim_100days_form_field_callback(): void {
    $formId = get_option('aim_form_100days_id') ?: 21185;
?>
    <input type="number" name="aim_form_100days_id" value="<?php echo isset($formId) ? esc_attr($formId) : ''; ?>">
<?php
}
