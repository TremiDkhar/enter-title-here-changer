<?php
/**
 * @package ETHC
 * @subpackage Admin
 * @author Tremi Dkhar
 * @since 0.4.0
 * @copyright Copyright (c) 2020, Tremi Dkhar
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

$post_types = get_post_types( '', 'object' );

// Remove the known post types that might not required to change the editor title placeholder.
unset(
	$post_types['attachment'],
	$post_types['revision'],
	$post_types['nav_menu_item'],
	$post_types['custom_css'],
	$post_types['customize_changeset'],
	$post_types['oembed_cache'],
	$post_types['user_request'],
	$post_types['wp_block']
);

?>
<div class="wrap">
	<h2><?php _e( 'Enter Title Here Changer Settings', 'ethc' ); ?></h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="postbox">
					<h3 style="font-size:1.3em;"><?php _e( 'Settings', 'ethc' ); ?></h3>
					<div class="inside">
						<noscript>Please enable JavaScript for this page to function correctly</noscript>
						<form method="post" action="<?php echo esc_url( add_query_arg( array( 'ethc-action' => 'modify' ) ) ); ?>">
							<table class="form-table ethc-settings">
								<tr valign="top">
									<td style="padding-left: 0;">
										<label>Post Type</label>
										<p>
											<?php
											if ( isset( $_GET['ethc-action'] ) && $_GET['ethc-action'] === 'edit' && wp_verify_nonce( $_GET['_wpnonce'], 'ethc_placeholder_nonce' ) ) {
												$edit_post = $_GET['post-type'];
											}
											?>
											<select class="widefat" name="post-type">
												<option></option>
												<?php
												foreach ( $post_types as $post_type => $object ) {

													// Exclude the post type that does not support title.
													if ( ! post_type_supports( $post_type, 'title' ) ) {
														continue;
													}

													// Exclude the post type that does not show in the ui.
													if ( false === $object->show_ui ) {
														continue;
													}
													?>
													<option value="<?php echo esc_attr( $post_type ); ?>" <?php selected( $post_type, isset( $edit_post ) ? $edit_post : '' ); ?>><?php echo esc_attr( $object->label ); ?></option>
													<?php
												}
												?>
											</select>
										</p>
									</td>
									<td>
										<label>Placeholder Title</label>
										<p>
											<input type="text" class="widefat" name="placeholder" required/>
										</p>
									</td>
									<td style="vertical-align: bottom">
										<!-- <span id="modify" class="button button-primary">Modify</span> -->
										<?php submit_button( 'Modify', 'primary', 'submit', false ); ?>
									</td>
								</tr>
							</table>
						</form>
						<?php
						require_once ETHC_PATH . '/admin/class-title-placeholder-table.php';
						$placeholder_table = new ETHC_Title_Placeholder_Table();
						$placeholder_table->prepare_items();
						?>
						<form id="ethc-placeholder" method="get" action="">
							<?php $placeholder_table->views(); ?>
							<?php $placeholder_table->display(); ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
