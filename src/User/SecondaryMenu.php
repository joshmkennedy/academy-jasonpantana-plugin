<?php

namespace JP\User;

class SecondaryMenu {


    public static function render() {
        $userId = get_current_user_id();
        if (!is_user_logged_in()) {
            return;
        }
        $items = self::getSecondaryMenuItems($userId);
        if (!$items || !is_array($items) || count($items) == 0) {
            return;
        }
?>
        <div class="jp-drop-down-menu">
            <button class="drop-down-menu__button user-menu">
                <?= dumpSvg('user'); ?>
            </button>
            <div class="drop-down-menu__content">
                <ul class="drop-down-menu__list">
                    <?php foreach ($items as $item): ?>
                        <li class="drop-down-menu__list-item">
                            <a href="<?= $item['link']; ?>" class="drop-down-menu__list-item-link">
                                <?php if (isset($item['icon'])): ?>
                                    <?= dumpSvg($item['icon']); ?>
                                <?php endif; ?>
                                <?= $item['label']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
<?php
    }

    private static function getSecondaryMenuItems($userId) {
        return apply_filters('jp_secondary_menu_items', [], $userId);
    }
}


// TODO: this is bad.
add_filter('jp_secondary_menu_items', function ($items, $userId) {
    global $aimClipListUserMeta;

    if (isset($aimClipListUserMeta)) {
        $clipLists = $aimClipListUserMeta->getSubscribedLists($userId);
        if ($clipLists && is_array($clipLists) && count($clipLists) > 0) {
            $items[] = [
                'label' => 'Learning Paths',
                'icon' => 'gear',
                'link' => aimSubscribedPathsLink()
            ];
        }
    }

    return $items;
}, 10, 2);

function aimSubscribedPathsLink() {
    return get_option('siteurl') . '/aim-learning-path-settings';
}
