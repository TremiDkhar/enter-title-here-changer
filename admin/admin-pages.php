<?php
/**
 * Admin management page for Enter Title Here settings
 *
 * @package ETHC\Admin
 * @since 0.1.0
 * @author Tremi Dkhar
 * @copyright Copyright (c) 2019, Tremi Dkhar
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die( '0' );
}

add_action( 'admin_init', 'ethc_register_settings' );
/**
 * Register setting, section and field required for the plugin.
 *
 * @since 0.1.1
 * @return void
 */
function ethc_register_settings() {

	register_setting( 'writing', 'ethc_settings', array( 'sanitize_callback' => 'ethc_sanitize' ) );
	add_settings_section( 'ethc_sections', 'Enter Title Here Changer', 'ethc_settings_section_callback', 'writing' );

	$posttypes = get_post_types();
	foreach ( $posttypes as $posttype ) {
		$args = array(
			'post_type' => $posttype,
			'label_for' => $posttype,
		);
		add_settings_field( 'eth_new_title_' . $posttype, $posttype, 'ethc_settings_field_callback', 'writing', 'ethc_sections', $args );
	}

	add_settings_field( 'enter_new_title_uninstall_on_delete', 'Do you want to remove plugin data when plugin is removed?', 'ethc_settings_uninstall', 'writing', 'ethc_sections', array( 'label_for' => 'ethc_settings_uninstall' ) );
}

/**
 * Added Settings section
 *
 * @since 0.1.1
 * @return void
 */
function ethc_settings_section_callback() {
	echo 'By default, the place holder of new post field is <kbd>Enter title here</kbd> or <kbd>Add title</kbd> in the latest WordPress. Using this settings will change to what title you want to display.';
}

/**
 * Add Settings fields for different custom post type.
 *
 * @param array $args | Argument needed for the input field.
 * @return void
 */
function ethc_settings_field_callback( $args ) {
	$ethc_settings = get_option( 'ethc_settings' );
	?>
	<input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="ethc_settings[<?php echo esc_attr( $args['post_type'] ); ?>]" value="<?php echo esc_attr( $ethc_settings[ $args['post_type'] ] ); ?>">
	<?php
}

/**
 * Delete plugin data on plugin uninstall?
 *
 * @param array $args | Argument needed for the input field.
 * @return void
 */
function ethc_settings_uninstall( $args ) {
	$ethc_settings = get_option( 'ethc_settings' );
	?>
	<input type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="ethc_settings[uninstall_on_delete]" <?php checked( true, $ethc_settings['uninstall_on_delete'] ); ?> >
	<?php
}

/**
 * Sanitize settings data before storing into database.
 *
 * @param array $settings | Raw settings data.
 * @return array
 */
function ethc_sanitize( $settings ) {
	$settings['uninstall_on_delete'] = isset( $settings['uninstall_on_delete'] ) ? true : false;

	return $settings;
}

add_filter( 'enter_title_here', 'ethc_new_title' );
/**
 * Change the placeholder based on post type
 *
 * @param string $title | The default placeholder.
 * @return string
 */
function ethc_new_title( $title ) {

	$screen    = get_current_screen()->id;
	$new_title = get_option( 'ethc_settings' );
	$title     = $new_title[ $screen ];

	return $title;
}
