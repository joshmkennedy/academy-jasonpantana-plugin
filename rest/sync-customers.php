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
    // Schedule the sync to run immediately in the background
    as_schedule_single_action(time(), 'jp_sync_action');

    return rest_ensure_response(['message' => 'Sync scheduled']);
}

// Hook the actual sync logic to action_scheduler
add_action('jp_sync_action', 'jp_sync_perform');

function jp_sync_perform() {
    $PER_PAGE = 100;
    $afterId = null;

    $logger = new \JP\SyncLogger();
    $stripe = new \JP\StripeClient();

    jp_sync_paginate($stripe, $logger, $afterId, $PER_PAGE);

    as_schedule_single_action(time() + 5 * MINUTE_IN_SECONDS, 'refresh_wp_reports');
}


add_action('refresh_wp_reports', 'refreshReports');

function refreshReports() {
    wp_remote_get('https://aim-sheets.developer-f70.workers.dev/wp-sync', [
        'headers' => [
            'Authorization' => '213f5721-4406-4fb5-b450-4ec80f7ef32a',
        ],
    ]);
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
        $email = in_array($customer->email, array_keys(jp_stripe_wp_email_map())) ? jp_stripe_wp_email_map()[$customer->email] : $customer->email;
        $user = get_user_by('email', $email);
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

function jp_stripe_wp_email_map() {
    return [
        'skabachia.realest@gmail.com' => 'steve@lentwong.com'
    ];
}
