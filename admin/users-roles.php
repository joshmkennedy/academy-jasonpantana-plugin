<?php
/**
 * User role management on WordPress users.php page.
 *
 * Allows appending roles to users from the native /wp-admin/users.php page
 * via bulk actions and inline role selection.
 *
 * @package JP
 */


/**
 * Add bulk action to assign role to multiple users.
 *
 * @param array $actions The bulk actions array.
 * @return array
 */
function jp_add_role_bulk_action( $actions ) {
	$available_roles = wp_roles()->roles;

	foreach ( $available_roles as $role_key => $role ) {
		$actions[ 'jp_add_role_' . $role_key ] = 'Add role: ' . $role['name'];
	}

	return $actions;
}
add_filter( 'bulk_actions-users', 'jp_add_role_bulk_action' );

/**
 * Handle bulk action for adding roles.
 *
 * @param string $redirect_url The redirect URL.
 * @param string $action       The action name.
 * @param array  $user_ids     The selected user IDs.
 * @return string
 */
function jp_handle_role_bulk_action( $redirect_url, $action, $user_ids ) {
	// Check if this is our custom action.
	if ( 0 !== strpos( $action, 'jp_add_role_' ) ) {
		return $redirect_url;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return $redirect_url;
	}

	// Extract role from action name.
	$role = substr( $action, 12 ); // Remove 'jp_add_role_' prefix.

	$available_roles = wp_roles()->roles;
	if ( ! isset( $available_roles[ $role ] ) ) {
		return $redirect_url;
	}

	// Add role to each selected user.
	$count = 0;
	foreach ( $user_ids as $user_id ) {
		$user = get_userdata( intval( $user_id ) );
		if ( $user && ! in_array( $role, $user->roles, true ) ) {
			$user->add_role( $role );
			$count++;
		}
	}

	// Add query parameter for custom notice.
	$redirect_url = add_query_arg(
		array(
			'jp_bulk_role_action' => sanitize_text_field( $action ),
			'jp_bulk_count'       => intval( $count ),
		),
		$redirect_url
	);

	return $redirect_url;
}
add_filter( 'handle_bulk_actions-users', 'jp_handle_role_bulk_action', 10, 3 );

/**
 * Display admin notice for bulk action results.
 */
function jp_bulk_action_admin_notice() {
	if ( ! isset( $_GET['jp_bulk_role_action'] ) ) {
		return;
	}

	$action = sanitize_text_field( $_GET['jp_bulk_role_action'] );
	$count  = isset( $_GET['jp_bulk_count'] ) ? intval( $_GET['jp_bulk_count'] ) : 0;

	if ( 0 === $count ) {
		return;
	}

	// Extract role from action name.
	$role = substr( $action, 12 ); // Remove 'jp_add_role_' prefix.

	$available_roles = wp_roles()->roles;
	if ( ! isset( $available_roles[ $role ] ) ) {
		return;
	}

	$message = sprintf(
		'Role "%s" added to %d user(s).',
		esc_html( $available_roles[ $role ]['name'] ),
		intval( $count )
	);

	echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
}
add_action( 'admin_notices', 'jp_bulk_action_admin_notice' );
