<?php

if (!function_exists("getCurrentURL")) {
    function getCurrentURL() {
        $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
            "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return $current_url;
    }
}

