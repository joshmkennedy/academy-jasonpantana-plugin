<?php
/**
 * Feature flag functions.
 *
 * @package JP
 */

if ( ! function_exists( 'feature_flag' ) ) {
	/**
	 * Check if a feature is enabled for the current user.
	 *
	 * @param string $flag The feature flag to check.
	 *
	 * @return bool True if the feature is enabled, false otherwise.
	 */
	function feature_flag( string $flag ): bool {
		$feature_flags_config = include __DIR__ . '/feature-flags-config.php';

		// Fail open if the flag is not registered.
		if ( ! isset( $feature_flags_config[ $flag ] ) ) {
			return true;
		}

		$settings = get_option( 'jp_feature_flags_settings', [] );

		// If no setting for this flag, it's not enabled for anyone.
		if ( ! isset( $settings[ $flag ] ) ) {
			return false;
		}

		$enabled_roles = $settings[ $flag ];

		// If no roles are selected for this flag, it's disabled for everyone.
		if ( empty( $enabled_roles ) ) {
			return false;
		}

		$current_user = wp_get_current_user();
		if ( ! $current_user->ID ) {
			// Not logged in, treat as a guest user with no roles.
			$user_roles = [];
		} else {
			$user_roles = $current_user->roles;
		}

		// Super admins have all flags enabled.
		if ( is_super_admin( $current_user->ID ) ) {
			return true;
		}

		// Check if any of the user's roles are in the enabled roles for the flag.
		foreach ( $user_roles as $role ) {
			if ( in_array( $role, $enabled_roles, true ) ) {
				return true;
			}
		}

		return false;
	}
}
