<?php
/**
 * @package ETHC
 * @subpackage Admin
 * @author Tremi Dkhar
 * @since 0.4.0
 * @copyright Copyright (c) 2020, Tremi Dkhar
 */

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
	exit();
}
$post_types = get_post_types( '', 'object' );

// Remove the known post types that are not required to change title.
unset( 	$post_types['attachment'],
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
						<form method="post" action="">
							<table class="form-table ethc-settings" style="width:auto;">
								<tr valign="top">
									<td style="padding-left: 0;">
										<label>Post Type</label>
										<p>
											<select>
												<option></option>
												<?php
												foreach( $post_types as $post_type ) {
												?>
													<option value="<?php echo esc_attr( $post_type->name );?>"><?php echo esc_attr( $post_type->label ); ?></option>
												<?php } ?>
											</select>
										</p>
									</td>
									<td>
										<label>Placeholder Title</label>
										<p>
											<input type="text" class="regular-text" />
										</p>
									</td>
									<td style="vertical-align: bottom">
										<span id="modify" class="button button-primary">Modify</span>
									</td>
								</tr>
							</table>
							<?php

							require_once ETHC_PATH . '/admin/class-title-placeholder-table.php';
							submit_button( 'Save Changes', 'primary', 'submit', true );

							?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>