<?php
namespace JP\Card;

interface CardInterface {
    public function __construct(\WP_Post $post);
    public function render(): void;
}
