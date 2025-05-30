<?php
add_action('rest_api_init', function () {

    // register_rest_route('jp/v1', '/sync-tools/categories', [
    // 	'methods' => 'GET',
    // 	'callback' => fn() => rest_ensure_response([
    // 		'success' => true,
    // 		'message' => 'Categories synced',
    // 	]),
    // ]);
    register_rest_route('jp/v1', '/sync-tools/tools', [
        'methods' => 'POST',
        'callback' => [JPSyncTools::class, 'toolsHandler'],
        'permission_callback' => function () {
            // Restrict who can use this endpoint as necessary
            // For example, only logged-in users who can list users:
            return current_user_can('manage_options');
        },
    ]);
    register_rest_route('jp/v1', '/sync-tools/categories', [
        'methods' => 'POST',
        'callback' => [JPSyncTools::class, 'categoriesHandler'],
        'permission_callback' => function () {
            // Restrict who can use this endpoint as necessary
            // For example, only logged-in users who can list users:
            return current_user_can('manage_options');
        },
    ]);
});

class JPSyncTools {
    const TAXONOMY = 'aim-tool-category';
    const POST_TYPE = 'aim-tool';
    const META_KEY = 'aim_tool_url';
    const META_KEY_ICON = 'aim_tool_icon';
    public static function toolsHandler(WP_REST_Request $request): WP_REST_Response {

        $err_group = [];
        $img_err_group = [];
        $body = json_decode($request->get_body());

        $tools = $body->tools;
        if (!is_array($tools)) return new WP_REST_Response('Invalid tools', 400);

        $total_tools = count($tools);
        // TODO: remove these debugging
        $success_icons = 0;
        $fail_icons = 0;
        foreach ($tools as $tool) {
            $tool = (object)$tool;
            $toolID = 0;
            if ($prevTool = self::toolByToolURL($tool->url)) {
                $res = wp_update_post([
                    'post_type' => self::POST_TYPE,
                    'ID' => $prevTool->ID,
                    'post_title' => $tool->title,
                ], true);
                if (is_wp_error($res)) {
                    $err_group[$tool->title] = $res->get_error_message();
                    continue;
                }
                $toolID = $prevTool->ID;
            } else {

                $res = wp_insert_post([
                    'post_type' => self::POST_TYPE,
                    'post_status' => 'publish',
                    'post_title' => $tool->title,
                ], true);
                if (is_wp_error($res)) {
                    $err_group[$tool->title] = $res->get_error_message();
                    continue;
                }
                $toolID = $res;

                $res = update_post_meta($toolID, self::META_KEY, $tool->url);
                if (!$res) {
                    $err_group[$tool->title] = "Could not insert toolurl";
                    continue;
                }

                if (!$tool->url) continue;

                try {
                    $iconUrl = self::findIcon($tool->url);
                    if (is_wp_error($iconUrl)) {
                        $err_group[$tool->title] = $iconUrl->get_error_message();
                        $fail_icons++;
                        continue;
                    }
                    if ($iconUrl) {
                        if (self::isValidUrl($iconUrl)) {

                            $res = update_post_meta($toolID, self::META_KEY_ICON, $iconUrl);
                            if (!$res) {
                                $err_group[$tool->title] = "Could not insert tool icon";
                                continue;
                            }
                            $success_icons++;
                        }
                    } else {
                        $fail_icons++;
                        $err_group[$tool->title] = "Could not find icon";
                        continue;
                    }
                } catch (Exception $e) {
                    $err_group[$tool->title] = "Could not find icon";
                    continue;
                }
            }

            $cats = array_map(function ($cat) {
                $term = get_term_by('slug', $cat, self::TAXONOMY);
                if (!$term) {
                    $term = wp_insert_term($cat, self::TAXONOMY, [
                        'name' => $cat,
                        'description' => $cat,
                    ]);
                    if (is_wp_error($term)) {
                        return 0;
                    }
                    return $term->term_id;
                }
                return get_term_by('slug', $cat, self::TAXONOMY)?->term_id;
            }, (array)$tool->categories);

            $res = wp_set_post_terms($toolID, $cats, self::TAXONOMY);
            if (is_wp_error($res)) {
                $err_group[$tool->title . ": categories"] = $res->get_error_message();
            }
        }

        $response = [];
        $response['total_tools'] = $total_tools;
        $response['success_icons'] = $success_icons;
        $response['fail_icons'] = $fail_icons;
        $response['tool_success_rate'] = $success_icons / $total_tools;
        if (count($err_group)) {

            if (count($err_group) === count($tools)) {
                $response['message'] = "All tools failed to sync";
                $response['errors'] = $err_group;
            } else {
                $response['message'] = "Some tools failed to sync";
                $response['errors'] = $err_group;
            }
        } else {
            $response['success'] = true;
            $response['message'] = "Tools synced";
        }

        return rest_ensure_response($response);
    }

    public static function categoriesHandler(WP_REST_Request $request): WP_REST_Response {
        $err_group = [];
        $body = json_decode($request->get_body());
        $categories = $body->categories;

        foreach ((array)$categories as $categoryName => $category) {
            $category = (array)$category;

            $slug = sanitize_title($categoryName);

            if (term_exists($slug, self::TAXONOMY)) {
                $term = get_term_by('slug', $slug, self::TAXONOMY);
                $res = wp_update_term($term->term_id, self::TAXONOMY, [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]);
                if (is_wp_error($res)) {
                    $err_group[$categoryName] = $res->get_error_message();
                }
            } else {

                $res = wp_insert_term([$category['name']], self::TAXONOMY, [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]);
                if (is_wp_error($res)) {
                    $err_group[$categoryName] = $res->get_error_message();
                }
            }
        }

        $response = [];

        if (count($err_group)) {

            if (count($err_group) === count((array)$categories)) {
                $response['message'] = "All categories failed to sync";
                $response['errors'] = $err_group;
            } else {
                $response['message'] = "Some categories failed to sync";
                $response['errors'] = $err_group;
            }
        } else {
            $response['success'] = true;
            $response['message'] = "Categories synced";
        }

        return rest_ensure_response($response);
    }


    /**
     * @param array<{name:string,category:string, url:string}> $tools
     * @return void 
     */
    public static function toolByToolURL($url) {
        $matches = get_posts([
            'post_type' => self::POST_TYPE,
            'posts_per_page' => 1,
            'meta_query' => [
                [
                    'key' => self::META_KEY,
                    'value' => strtolower($url),
                ],
            ]
        ]);
        if (count($matches)) {
            return $matches[0];
        }
        return null;
    }

    public static function findIcon($url) {

        $html = JP\OpenGraph::fetch_content_with_browser_headers($url);
        if (is_wp_error($html)) {
            return $html;
        }
        if (!$html) {
            return new WP_Error("Could not fetch tool content for getting icon");
        }
        $urlParts = parse_url($url);
        $rootUrl = $urlParts['scheme'] . '://' . $urlParts['host'];
        error_log($rootUrl . ": is the root url of $url");
        $og = JP\OpenGraph::parse($html,$rootUrl);

        if (!$og) {
            return new WP_Error("Could not parse $url's markup tool content for getting icon");
        }
        error_log($og->icon);
        if (property_exists($og, 'icon')) {
            if (self::isValidUrl($og->icon)) {
                return $og->icon;
            }
        }
        error_log($og->apple_touch_icon);
        if (property_exists($og, 'apple-touch-icon')) {
            if (self::isValidUrl($og->apple_touch_icon)) {
                return $og->apple_touch_icon;
            }
        }


        try {
            $req = wp_remote_get($urlParts['scheme'] . '://' . $urlParts['host'] . '/favicon.ico');
            if (is_wp_error($req)) {
                return false;
            }
            $code = wp_remote_retrieve_response_code($req);
            if ($code <= 400) {
                error_log("Got icon from favicon strategy");
                return $urlParts['scheme'] . '://' . $urlParts['host'] . '/favicon.ico';
            }
            error_log(print_r($og, true));
            return false;
        } catch (Exception) {
            return false;
        }
    }

    private static function isValidUrl($url) {
        $url = parse_url($url);
        return $url['scheme'] && $url['host'];
    }
}
