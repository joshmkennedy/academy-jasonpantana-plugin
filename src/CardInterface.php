<?php
namespace JP;

interface CardInterface {
    public function __construct();
    public function render(\WP_Post $post): void;
}
