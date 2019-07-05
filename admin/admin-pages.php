<?php
/**
 * Admin management page for Enter Title Here settings
 *
 * @package ETHC\Admin
 * @since 0.1.0
 * @author Tremi Dkhar
 * @copyright Copyright (c) 2019, Tremi Dkhar
 */

if ( ! defined( 'ABSPATH' ) ) die(); // phpcs:ignore Generic.ControlStructures.InlineControlStructure.NotAllowed

add_action( 'admin_init', 'ethc_register_settings' );
function ethc_register_settings() {
	register_setting( 'writing', 'ethc_options' );
	add_settings_section( 'ethc_sections', 'Enter Title Here Changer', 'ethc_settings_section_callback', 'writing' );
	add_settings_field( 'ethc_new_title', 'Enter New Title', 'ethc_settings_field_callback', 'writing', 'ethc_sections', array( 'label_for' => 'ethc_new_title' ) );
}


function ethc_settings_section_callback( $args ) {
	echo 'By default, the place holder of new post field is <kbd>Enter title here</kbd> or <kbd>Add title</kbd> in the latest WordPress. Using this settings will change to what title you want to display.';
}

function ethc_settings_field_callback( $args ) {
	$options = get_option( 'ethc_options' );
	?>
	<input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="ethc_options" value="<?php echo isset( $options ) ? esc_attr( $options ) : ''; ?>">
	<?php
}

add_filter( 'enter_title_here', 'ethc_new_title' );
function ethc_new_title( $title ) {
	$options = get_option( 'ethc_options' );
	if ( isset( $options ) ) {
		$title = $options;
	}

	return $title;
}