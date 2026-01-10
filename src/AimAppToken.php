<?php

namespace JP;

class AimAppToken {
    public function __construct(public string $userId) {
    }

    public function getToken(): string {
        $data = get_user_meta($this->userId, 'prompt_studio_token', true);

        if ($data && !empty($data['token']) && !empty($data['expires'])) {
            if ($data['expires'] > time()) {
                return $data['token'];
            }
        }

        $token = $this->genToken();
        update_user_meta($this->userId, 'prompt_studio_token', [
            'token' => $token,
            'expires' => time() + DAY_IN_SECONDS,
        ]);

        return $token;
    }

    public function genToken(): string {
        return sprintf("%s--%s", bin2hex(random_bytes(32)), $this->userId);
    }

    public static function verifyToken(string $token): ?array {
        // Extract userId from token format: {random}--{userId}
        $parts = explode('--', $token);
        if (count($parts) !== 2) {
            return null;
        }

        $userId = (int) $parts[1];
        if (!$userId) {
            return null;
        }

        $data = get_user_meta($userId, 'prompt_studio_token', true);
        if (!$data || empty($data['token']) || empty($data['expires'])) {
            return null;
        }

        // Check expiration
        if ($data['expires'] <= time()) {
            return null;
        }

        // Verify token matches (timing-safe comparison)
        if (!hash_equals($data['token'], $token)) {
            return null;
        }

        return ['user_id' => $userId];
    }
}
