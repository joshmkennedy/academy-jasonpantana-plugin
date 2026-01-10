<?php

namespace JP\LoggedInMenu;

use JP\AimAppToken;

/** @package JP\LoggedInMenu */
class PromptStudioMenuItem {
    public bool $isLoggedIn;
    public bool $hasAccessToStudio;
    public string $token;
    public string $userId;

    private AimAppToken $aimAppToken;

    public function __construct(
        public string $url,
    ) {
        $this->isLoggedIn = is_user_logged_in();
        if ($this->isLoggedIn) {
            $this->userId = get_current_user_id();
            $this->hasAccessToStudio = $this->hasAccess($this->userId);
            $this->aimAppToken = new AimAppToken($this->userId);
            $this->token = $this->aimAppToken->getToken();
            $this->url = get_option('prompt_studio_url') ?: $this->url;
        }
    }

    public function hasAccess($userId):bool{
        $groups = array_filter(\learndash_get_users_group_ids($userId), fn($id) => isPaidGroup($id));
        return count($groups) > 0;
    }

    public function link() {
        if(!$this->isLoggedIn || !$this->hasAccessToStudio) return "";
        return sprintf("%s%s", $this->url, $this->token ? "?token={$this->token}" : "");
    }

    public function createMenuItem () {
        if (!$this->isLoggedIn || !$this->hasAccessToStudio) return "";
        if (!$this->token) return "";
        ob_start(); ?>
        <div class="header-button-wrap prompt-studio-wrapper" data-state="uninitialized" >
            <div class="header-button-inner-wrap">
            <a href="<?= $this->link(); ?>" target="_blank" class="button header-button button-size-custom prompt-studio-link" >
                <?= dumpSvg("promptstudio-logo"); ?>
        </a>
            </div>
        </div>
<?php return ob_get_clean();
    }
}
