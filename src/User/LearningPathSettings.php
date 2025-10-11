<?php

namespace JP\User;

use JP\SafeMethodCaller;

class LearningPathSettings {
    public $clipQueryVars = [
        'aim-learning-path-settings',
    ];

    private $usermeta;
    public function __construct() {
        global $aimClipListUserMeta;
        $this->usermeta = new SafeMethodCaller($aimClipListUserMeta, 'AimClipListUserMeta');
    }

    public function addVars(array $vars) {
        return array_merge($vars, $this->clipQueryVars);
    }

    public function rewriteRules() {
        add_rewrite_tag('%aim-learning-path-settings%', '([^&]+)');
        add_rewrite_rule('^aim-learning-path-settings/?$', 'index.php?aim-learning-path-settings=1', 'top');
    }

    public function isOnPage() {
        return get_query_var('aim-learning-path-settings') == 1 && is_user_logged_in();
    }

    /// ------------------------
    //  TEMPLATE HELPERS
    /// ------------------------

    public function unsubscribeList($listId) {
        $userId = get_current_user_id();
        $this->usermeta->deleteNextEmailForList($userId, $listId);
        $this->usermeta->removeSubscribedList($userId, $listId);
    }

    public function getReceivedEmailsForList($listId) {
        $userId = get_current_user_id();
        return $this->usermeta->getReceivedEmailsForList($userId, $listId);
    }

    public function getActiveList() {
        $userId = get_current_user_id();
        return $this->usermeta->getLastActiveSubscription($userId);

    }

    public function getLists() {
        $userId = get_current_user_id();
        return $this->usermeta->getSubscribedLists($userId);
    }
}

