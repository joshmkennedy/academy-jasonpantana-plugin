<?php

add_action('rest_api_init', function () {
    register_rest_route('jp/v1', '/sync', array(
        'methods' => 'POST',
        'callback' => 'jp_sync',
        'permission_callback' => function () {
            // Restrict who can use this endpoint as necessary
            // For example, only logged-in users who can list users:
            return current_user_can('list_users');
        },

    ));
});

function jp_sync(WP_REST_Request $request): WP_REST_Response {
    $PER_PAGE = 100;
    $afterId = null;
    $hasMore = true;

    $logger = new \JP\SyncLogger();
    $stripe = new \JP\StripeClient();

    jp_sync_paginate($stripe, $logger, $afterId, $PER_PAGE);

    return rest_ensure_response(['message' => 'ok']);
}

function jp_sync_paginate(
    \Stripe\StripeClient $stripe,
    \JP\SyncLogger $logger,
    $afterId = null,
    $limit = 100,
) {
    $args = [
        'limit' => $limit,
        'expand' => ['data.subscriptions'],
    ];
    if ($afterId) {
        $args['starting_after'] = $afterId;
    }
    $customers = $stripe->customers->all($args);

    foreach ($customers->data as $customer) {
        $user = get_user_by('email', $customer->email);
        if (!$user) {
            $logger->log("No user found for email {$customer->email}");
            continue;
        }

        // is there an active subscription?
        $activeSubscriptions = array_filter($customer->subscriptions->data, function ($subscription) {
            return $subscription->status === 'active';
        });
        $hasActiveSubscriptions = count($activeSubscriptions) > 0;

        $activeGroups = array_filter(\learndash_get_users_group_ids($user->ID), fn($id) => isPaidGroup($id));
        $hasActiveGroup = count($activeGroups) > 0;


        // If we are subscribed in stripe but not 
        // in learndash add the group to user;
        if ($hasActiveSubscriptions && !$hasActiveGroup) {
            $logger->log("User ({$user->ID}) {$user->user_email} has an active subscription but no paid group");
            // for now just take the first subscription
            $subscription = $activeSubscriptions[0];
            $groupId = array_reduce($subscription->items->data, function ($possible, $item) {
                if ($possible) return $possible;
                return stripeProductGroupMap($item->plan->product);
            }, null);
            if (!$groupId) {
                $logger->log("Could not find plan for {$subscription->id}");
                continue;
            }

            learndash_set_users_group_ids($user->ID, [$groupId]);
        }

        // If we are subscribed in learndash but not 
        // in stripe remove the group from the user;
        if (!$hasActiveSubscriptions && $hasActiveGroup) {
            $logger->log("User {$user->ID} has a paid group but no active subscription");
            learndash_set_users_group_ids($user->ID, []); // empty array removes all groups
        }
    }

    if ($customers->has_more) {
        $logger->log("Has more");
        jp_sync_paginate($stripe, $logger, $customers->data[count($customers->data) - 1]->id, $limit);
    }
}
