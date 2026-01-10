<?php

namespace JP;

class AimAppToken {
    public function __construct(public string $userId) {
    }

    public function init() {
    }
    

    public function getToken(): string {
        if($token = get_transient("prompt_studio_token_{$this->userId}")){
            return $token;
        }
        $token = $this->genToken();
        set_transient("prompt_studio_token_{$this->userId}", $token, \DAY_IN_SECONDS);
        return $token;
    }

    public function genToken(): string {
        return sprintf("%s--%s", bin2hex(random_bytes(32)), $this->userId);
    }

}
