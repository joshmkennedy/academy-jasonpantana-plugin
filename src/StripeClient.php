<?php

namespace JP;

class StripeClient extends \Stripe\StripeClient {
    public function __construct() {
        if (!get_option('jp_stripe_api_key')) {
            throw new \Exception("Stripe API key not set");
        }
        parent::__construct(get_option('jp_stripe_api_key'));
    }
}
