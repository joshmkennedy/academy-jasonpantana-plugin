<?php
// I AM NOT USING THIS YET
// I AM NOT USING THIS YET
// I AM NOT USING THIS YET
// I AM NOT USING THIS YET
// I AM NOT USING THIS YET
// I AM NOT USING THIS YET


// Add the toggle to post and page edit screens
add_action('add_meta_boxes', function () {
    add_meta_box(
        'protect_from_public_with_form',
        'Protect from Public (Show Form)',
        function ($post) {
            $value = get_post_meta($post->ID, 'protect_from_public_with_form', true);
            wp_nonce_field('protect_from_public_with_form_nonce', 'protect_from_public_with_form_nonce_field');
            ?>
            <label for="protect_from_public_with_form_toggle">
                <input type="checkbox" id="protect_from_public_with_form_toggle" name="protect_from_public_with_form" value="1" <?php checked($value, '1'); ?> />
                Enable protection (show form to view)
            </label>
            <?php
        },
        ['post', 'page'],
        'side',
        'default'
    );
});

// Save the meta value
add_action('save_post', function ($post_id) {
    if (!isset($_POST['protect_from_public_with_form_nonce_field']) ||
        !wp_verify_nonce($_POST['protect_from_public_with_form_nonce_field'], 'protect_from_public_with_form_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['post_type']) && in_array($_POST['post_type'], ['post', 'page'])) {
        if (!current_user_can('edit_post', $post_id)) return;
    }
    $value = isset($_POST['protect_from_public_with_form']) ? '1' : '0';
    update_post_meta($post_id, 'protect_from_public_with_form', $value);
});

// Register the post meta
add_action('init', function () {
    register_post_meta('', 'protect_from_public_with_form', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'auth_callback' => function() { return current_user_can('edit_posts'); },
    ]);
});
