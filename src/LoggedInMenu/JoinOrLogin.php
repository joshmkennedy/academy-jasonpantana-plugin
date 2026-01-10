<?php

namespace JP\LoggedInMenu;

use JP\User\SecondaryMenu;

class JoinOrLogin
{
    private array $opts;

    public function __construct(
        private PromptStudioMenuItem $promptStudioMenuItem,
        array $opts = [])
    {
        $this->opts = $opts;
    }

    public function shortcode(): callable
    {
        return function () {
            $url = getCurrentURL();
            $registration = "registration/";
            if (strpos($url, $registration) != false) {
                return null;
            }
            $isProfilePage = is_page('profile');
            $userId = get_current_user_id();
            $groups = array_filter(learndash_get_users_group_ids($userId), fn($id) => isPaidGroup($id));
            $link = ($userId > 0) ? (
                count($groups) ? "/profile" : getRegistrationURL($userId, "/choose-your-plan")
            ) : "/choose-your-plan/";
            $buttonText = $userId > 0 ? (
                count($groups) ? "My Profile" : "Finish Account Setup"
            ) : "Join Now";
            ob_start(); ?>

            <?= $this->promptStudioMenuItem->createMenuItem(); ?>

            <div class="header-button-wrap">
                <div class="header-button-inner-wrap">
                    <a href="<?= $link; ?>" target="_self" class="button header-button button-size-custom button-style-filled button-style-gradient--primary <?= $isProfilePage ? 'on-profile' : ''; ?>" style="padding-block:16px;">
                        <?= $buttonText; ?>
                    </a>

                    <?php SecondaryMenu::render(); ?>
                </div>
            </div>

<?php return ob_get_clean();
        };
    }
}
