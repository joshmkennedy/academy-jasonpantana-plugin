<?php

namespace JP;

interface IconCardPropertyAccessorInterface {
    public function getItemLink(mixed $item): string;
    public function getItemIcon(mixed $item): string;
    public function getItemColor(mixed $item): string;
    public function getItemTitle(mixed $item): string;
}
