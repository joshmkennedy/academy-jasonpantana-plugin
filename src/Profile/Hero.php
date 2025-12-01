<?php

namespace JP\Profile;

// For displaying the nofication banners.
// For displaying featured content carousel.
// For displaying the sidebar product. (for now its the "Aim Experts" formally known as aim instructors)


class Hero {
    public function __construct() {
    }

    public function render() {
        $mainSnippet = (new \JP\ContentSnippets\RenderSnippet("main-hero-snippet"))->render();
        $hasAccessToInstructors = feature_flag('instuctors');
?>
        <div class="profile-hero">
            <div class="profile-user-notices">
                <?php $this->renderNotices([
                    // banner for the assessment to sign up for the 100 days.
                    fn() => (new \JP\Aim100daysModal())->renderNotice(),
                ]); ?>
            </div>

            <div class="profile-hero__container">
                <?php if ($hasAccessToInstructors): ?>
                    <div class="profile-hero__sidebar">
                        <?php (new Instructors())->render(); ?>
                    </div>
                <?php endif; ?>

                <?php if ($mainSnippet): ?>
                    <div class="profile-hero__main">
                        <?= $mainSnippet; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
        <?php
    }

    public static function renderNotices(array $banners): void {
        $max = 2;
        foreach ($banners as $bannerCB) {
            if ($max <= 0) break;

            $content = call_user_func($bannerCB);
            if (!$content) continue;
            $max--
        ?>
            <div class="profile-user-notice shimmer">
                <div class="contents shimmer">
                    <?= $content; ?>
                </div>
            </div>
<?php
        }
    }
}
