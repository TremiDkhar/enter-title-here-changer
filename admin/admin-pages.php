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

	$posttypes = get_post_types();
	foreach ( $posttypes as $posttype ) {
		add_settings_field( 'eth_new_title_' . $posttype, $posttype, 'ethc_settings_field_callback', 'writing', 'ethc_sections', array( 'post_type' => $posttype ) );
	}
}


function ethc_settings_section_callback( $args ) {
	echo 'By default, the place holder of new post field is <kbd>Enter title here</kbd> or <kbd>Add title</kbd> in the latest WordPress. Using this settings will change to what title you want to display.';
}

function ethc_settings_field_callback( $args ) {
	$options = get_option( 'ethc_options' );
	?>
	<input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="ethc_options[<?php echo esc_attr( $args['post_type'] ); ?>]" value="<?php echo $options[$args['post_type'] ]; ?>">
	<?php
}

add_filter( 'enter_title_here', 'ethc_new_title' );
function ethc_new_title( $title ) {

	$screen  = get_current_screen();

	$new_title = get_option( 'ethc_options' );

	if ( isset( $new_title ) ) {
		$title = $new_title;
	}

	return $title;
}
