<?php

add_action(
    'wp_enqueue_scripts',
    function () {
        if(is_registration_page()){
            enqueueAsset('registration-form');
        }
    }
);

function is_registration_page(): bool {
    $url = getCurrentURL();
    return strpos($url, 'registration') !== false;
}
