<?php

namespace JP\Profile;


class Instructors {
    public array $instructors = [];
    public array $copy = ["heading"=> "AiM Experts", "tagline"=>"For hands-on help, schedule a one-on-one with an AiM expert."];
    public function __construct() {
        $this->instructors = array_map(
            fn(\WP_User $user) => [
                'id' => $user->ID,
                'name' => sprintf("%s %s", $user->first_name, $user->last_name),
                'img' => wp_get_attachment_image_url(get_user_meta($user->ID, 'instructor-profile-img-id', true), 'medium'),
                'focus_description' => get_user_meta($user->ID, 'instructor-speacialties-ai-area-of-focus-description', true),
                'tags' => get_user_meta($user->ID, 'instructor-speacialties-tags', true),
                'calendlyLink' => get_user_meta($user->ID, 'instructor-calendly-link', true),
                'instructor_menu_order' => (int)(get_user_meta($user->ID, 'instructor-menu-order', true)),
            ],
            get_users([
                'meta_query' => [
                    [
                        'key' => 'instructor-is-available',
                        'compare' => 'EXISTS',
                    ],
                ],
                'meta_key' => 'instructor-menu-order',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
            ])
        );
        $this->copy = (array)get_option('jp_instructor_settings', $this->copy);
    }
    public function render(): void {
        if (!feature_flag('instuctors')) return;
        if (empty($this->instructors) || !is_array($this->instructors) || count($this->instructors) === 0) return;
        add_action('wp_footer', [$this, 'renderData']);
?>
        <div class="profile-aim-instructors__container">
            <div class="profile-aim-instructors__layout">
                <div class="instructors-header">
                    <h3><?= $this->copy['heading']; ?></h3>
                    <p><?= $this->copy['tagline']; ?></p>
                </div>
                <ul class="profile-instructors-list">
                    <?php foreach ($this->instructors as $instructor): ?>
                        <li class="profile-instructor-list-item" data-id="<?= $instructor['id']; ?>" data-order="<?= $instructor['instructor_menu_order']; ?>">
                            <button class="profile-instructor-trigger" data-user-id="<?= $instructor['id']; ?>">
                                <img src="<?= $instructor['img']; ?>" alt="<?= $instructor['name']; ?>" width="100" height="100" />
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php
    }

    public function renderData(): void {
        $data = json_encode($this->instructors);
    ?>
        <script>
            window.aimInstructorsData = <?= $data; ?>
        </script>
<?php
    }
}
