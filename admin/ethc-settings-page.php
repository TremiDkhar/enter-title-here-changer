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

$post_types = get_post_types(
	array(
		'public'   => true,
		'show_ui'  => true,
	),
	'object'
);

// Post types that don't use the standard title editor field.
$excluded_post_types = array_flip( array(
	'attachment',
) );

$supported_post_types = array_filter(
	$post_types,
	function ( $post_type ) use ( $excluded_post_types ) {
		return ! isset( $excluded_post_types[ $post_type->name ] )
			&& post_type_supports( $post_type->name, 'title' );
	}
);

?>
<div class="ethc-wrap wrap">
	<h2><?php esc_html_e( 'Enter Title Here Changer Settings', 'enter-title-here-changer' ); ?></h2>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="postbox">
					<h3 style="font-size:1.3em;"><?php esc_html_e( 'Settings', 'enter-title-here-changer' ); ?></h3>
					<div class="inside">
						<noscript>Please enable JavaScript for this page to function correctly</noscript>
						<form method="post" action="<?php echo esc_url( add_query_arg( array( 'ethc-action' => 'edit' ) ) ); ?>">
							<table class="form-table ethc-settings">
								<tr valign="top">
									<td style="padding-left: 0;">
										<label>Post Type</label>
										<p>
											<?php
											if (
													isset( $_GET['ethc-action'] ) &&
													'modify' === $_GET['ethc-action'] &&
													isset( $_GET['ethc-placeholder-nonce'] ) &&
													wp_verify_nonce( $_GET['ethc-placeholder-nonce'], 'ethc_placeholder_nonce' )
												) {
												$edit_post = $_GET['post-type'];
											}
											?>
											<select id="post-type" class="widefat" name="post-type">
												<option></option>
												<?php
												foreach ( $post_types as $post_type => $object ) {
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
											<input type="text" id="placeholder" class="widefat" name="placeholder" required/>
										</p>
									</td>
									<td style="vertical-align: bottom">
										<!-- <span id="modify" class="button button-primary">Modify</span> -->
										<p>
											<input type="hidden" name="ethc-placeholder-nonce" value="<?php echo esc_attr( wp_create_nonce( 'ethc_placeholder_nonce' ) ); ?>" />
											<?php submit_button( 'Modify', 'primary', 'submit', false ); ?>
										</p>
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
