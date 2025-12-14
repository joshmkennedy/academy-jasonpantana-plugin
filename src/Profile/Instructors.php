<?php

namespace JP\Profile;


class Instructors {
    public array $instructors = [];
    public array $tagData = [];
    public array $settings = [
        "heading" => "AiM Experts",
        "tagline" => "Book personalized one-on-one strategy sessions with our AI and marketing specialists.",
        'view_all' => "https://aimarketingacademy.as.me/",
    ];
    public function __construct() {
        $this->instructors = array_map(
            fn(\WP_User $user) => [
                'id' => $user->ID,
                'name' => sprintf("%s %s", $user->first_name, $user->last_name),
                'img' => wp_get_attachment_image_url(get_user_meta($user->ID, 'instructor-profile-img-id', true), 'medium'),
                'focus_description' => get_user_meta($user->ID, 'instructor-speacialties-ai-area-of-focus-description', true),
                'tags' =>[
                    'expert-in-tags'=> get_user_meta($user->ID, 'expert-in-tags', true) ?? [],
                    'expert-with-tags'=> get_user_meta($user->ID, 'expert-with-tags', true) ?? [],
                ],
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
                'posts_per_page' => 5,
                'meta_key' => 'instructor-menu-order',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
            ])
        );

        $this->tagData = get_terms([
            'hide_empty' => false,
            'fields'=> 'id=>name',
            'taxonomy' => ['expert-in-tag', 'expert-with-tag'],
        ]);

        $this->settings = (array)get_option('jp_instructor_settings', $this->settings);
    }
    public function render(): void {
        if (!feature_flag('instuctors')) return;
        if (empty($this->instructors) || !is_array($this->instructors) || count($this->instructors) === 0) return;
        add_action('wp_footer', [$this, 'renderData']);
?>
        <div class="profile-aim-instructors__container">
            <div class="profile-aim-instructors__layout">
                <div class="instructors-header">
                    <h3><?= $this->asExpertLogo($this->settings['heading']); ?></h3>
                    <p><?= $this->settings['tagline']; ?></p>
                </div>
                <ul class="profile-instructors-list">
                    <?php foreach ($this->instructors as $instructor): ?>
                        <li class="profile-instructor-list-item" data-id="<?= $instructor['id']; ?>" data-order="<?= $instructor['instructor_menu_order']; ?>">
                            <button class="profile-instructor-trigger" data-user-id="<?= $instructor['id']; ?>">
                                <img src="<?= $instructor['img']; ?>" alt="<?= $instructor['name']; ?>" width="100" height="100" />
                            </button>
                        </li>
                    <?php endforeach; ?>

                    <li class="profile-instructor-list-item">
                        <a class="profile-instructor-link" href="<?= $this->settings['view_all']; ?>" target="_blank">
                            <span class="wrap-in-circle">
                                <?= dumpSvg('grid'); ?>
                                <span class="profile-instructor-link__text">View All</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    <?php
    }

    public function renderData(): void {
        $data = json_encode($this->instructors);
        $tagData = json_encode($this->tagData);
    ?>
        <script>
            window.aimInstructorsData = <?= $data; ?>;
            window.aimInstructorsTagData = <?= $tagData; ?>;
        </script>
<?php
    }

    private function asExpertLogo(string $heading): string {
        return str_replace('AiM', '<span>AiM</span>', $heading);
    }
}
