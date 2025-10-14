<?php

add_action('wp_enqueue_scripts', function () {
    if (get_post_type() == 'sfwd-lessons' && learndash_is_sample(get_the_ID())) {
        enqueueAsset('protect-free-lesson');
    }
});

add_action('wp', function () {
    $COOKIE_NAME = "signed_up_for_free_lessons";
    if (
        get_post_type() == 'sfwd-lessons'
        && learndash_is_sample(get_the_ID())
        && wp_get_current_user()->ID == 0
        && !isset($_COOKIE[$COOKIE_NAME])
    ) {
        add_required_signup_modal();
    }
});

function add_required_signup_modal() {
    $title = get_the_title();
?>
    <div id="free-lesson-signup" class="free-lesson-signup__popup" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000; background: rgba(0, 0, 0, 0.5); ">
        <div class="free-lesson-signup__overlay"></div>
        <div class="free-lesson-signup__container">
            <div class="free-lesson-signup__content">
                <h2 class="free-lesson-signup__heading" data-title="<?= $title; ?>">
                    <?= $title; ?>
                </h2>
                <p>Get instant access to this free lesson</p>

                <form id="free-lesson-signup__form">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <button type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
<?php
}
