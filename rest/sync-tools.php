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
	public static function toolsHandler(WP_REST_Request $request): WP_REST_Response {
		$err_group = [];

		$body = json_decode($request->get_body());

		$tools = $body->tools;
		foreach ($tools as $tool) {
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
			}

			$cats = array_map(function ($cat) {
				return get_term_by('slug', $cat, self::TAXONOMY)?->term_id;
			}, (array)$tool->categories);

			$res = wp_set_post_terms($toolID, $cats, self::TAXONOMY);
			if (is_wp_error($res)) {
				$err_group[$tool->title . ": categories"] = $res->get_error_message();
			}
		}

		$response = [];

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
		$categories = json_decode($request->get_body());

		foreach ((array)$categories as $categoryName => $category) {

			$slug = sanitize_title($categoryName);

			if (term_exists($slug, self::TAXONOMY)) {
				$term = get_term_by('slug', $slug, self::TAXONOMY);
				$res = wp_update_term($term->term_id, self::TAXONOMY, [
					'name' => $category->name,
					'description' => $category->description,
				]);
				if (is_wp_error($res)) {
					$err_group[$categoryName] = $res->get_error_message();
				}
			} else {

				$res = wp_insert_term($slug, self::TAXONOMY, [
					'name' => $category->name,
					'description' => $category->description,
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
}
