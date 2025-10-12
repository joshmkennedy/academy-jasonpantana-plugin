<?php
/**
 * Feature flags admin page.
 *
 * @package JP
 */

/**
 * Register the admin page.
 */
function jp_register_feature_flags_page() {
	add_submenu_page(
		'jp-settings',
		'Feature Flags',
		'Feature Flags',
		'manage_options',
		'jp-feature-flags',
		'jp_feature_flags_page_html'
	);
}
add_action( 'admin_menu', 'jp_register_feature_flags_page' );

/**
 * Render the admin page.
 */
function jp_feature_flags_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Handle form submission
	if ( isset( $_POST['jp_feature_flags_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['jp_feature_flags_nonce'] ), 'jp_feature_flags_save' ) ) {
		$settings             = [];
		$feature_flags_config = include __DIR__ . '/feature-flags-config.php';
		$roles                = get_editable_roles();

		$posted_flags = isset( $_POST['feature_flags'] ) ? (array) $_POST['feature_flags'] : [];

		foreach ( $feature_flags_config as $flag => $details ) {
			$settings[ $flag ] = [];
			foreach ( $roles as $role_key => $role_info ) {
				if ( isset( $posted_flags[ $flag ][ $role_key ] ) ) {
					$settings[ $flag ][] = $role_key;
				}
			}
		}
		update_option( 'jp_feature_flags_settings', $settings );
		echo '<div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>';
	}

	$feature_flags_config = include __DIR__ . '/feature-flags-config.php';
	$roles                = get_editable_roles();
	$current_settings     = get_option( 'jp_feature_flags_settings', [] );
	?>
    <style>
        .column-role {
            text-align: center;
        }
    </style>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post" action="">
			<?php wp_nonce_field( 'jp_feature_flags_save', 'jp_feature_flags_nonce' ); ?>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th scope="col" id="feature" class="manage-column column-feature">Feature</th>
						<th scope="col" class="manage-column column-role">All Roles</th>
						<?php foreach ( $roles as $role ) : ?>
                            <th scope="col" class="manage-column column-role" style="width:1em;">
                            <span style="writing-mode: vertical-rl; rotate: 180deg;" hight="1em">
                                <?php echo esc_html( $role['name'] ); ?>
                            </span>
                            </th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody id="the-list">
					<?php if ( empty( $feature_flags_config ) ) : ?>
						<tr>
							<td colspan="<?php echo count( $roles ) + 2; ?>">No feature flags configured.</td>
						</tr>
					<?php else : ?>
						<?php foreach ( $feature_flags_config as $flag => $details ) : ?>
							<tr>
								<td class="feature column-feature" style="min-width:fit-content">
                                    <p> 
									<strong><?php echo esc_html( $details['label'] ); ?></strong>
                                    </p>
									<p class="description"><?php echo esc_html( $details['description'] ); ?></p>
								</td>
								<td class="role column-role" style="vertical-align:middle">
									<label>
										<input type="checkbox" class="check-all-roles">
										<span class="screen-reader-text">Enable for all roles</span>
									</label>
								</td>
								<?php foreach ( $roles as $role_key => $role_info ) : ?>
									<td class="role column-role" style="vertical-align:middle"> 
										<label>
											<input type="checkbox" name="feature_flags[<?php echo esc_attr( $flag ); ?>][<?php echo esc_attr( $role_key ); ?>]"
												<?php
												$is_enabled = isset( $current_settings[ $flag ] ) && in_array( $role_key, (array) $current_settings[ $flag ], true );
												checked( $is_enabled, true );
												?>
											>
											<span class="screen-reader-text">Enable for <?php echo esc_html( $role['name'] ); ?></span>
										</label>
									</td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const checkAllCheckboxes = document.querySelectorAll('.check-all-roles');
			checkAllCheckboxes.forEach(function(checkbox) {
				checkbox.addEventListener('change', function() {
					const row = this.closest('tr');
					const roleCheckboxes = row.querySelectorAll('input[type="checkbox"][name^="feature_flags"]');
					roleCheckboxes.forEach(function(roleCheckbox) {
						roleCheckbox.checked = this.checked;
					}, this);
				});
			});
		});
	</script>
	<?php
}
