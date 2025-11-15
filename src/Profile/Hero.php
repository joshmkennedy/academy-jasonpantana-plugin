<?php

namespace JP\Profile;

// For displaying the nofication banners.
// For displaying featured content carousel.
// For displaying the sidebar product. (for now its the "Aim Experts" formally known as aim instructors)


class Hero {
    public function __construct() {
    }

    public function render() {
?>
        <div class="profile-hero">
            <div class="profile-user-notices">
                <?php $this->renderNotices([
                    // banner for the assessment to sign up for the 100 days.
                    fn() => (new \JP\Aim100daysModal())->renderNotice(),
                ]); ?>
            </div>
            <div class="profile-hero__container">
                <div class="profile-hero__sidebar">
                    <?php (new Instructors())->render(); ?>
                </div>

                <div class="profile-hero__main">

                </div>
            </div>
        </div>
        <?php
    }

    public function renderNotices(array $banners): void {
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
