<?php
/**
 * Custom function to retrive the plugin option from the database
 *
 * @package ETHC
 * @subpackage Admin\Options
 * @author Tremi Dkhar
 * @copyright Copyright (c) 2020, Tremi Dkhar
 * @since 0.4.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Retrive the Enter Title Here Changer plugin option from the database.
 *
 * @since 0.4.0
 * @param string $key Option name.
 * @return string The value for the supplied $key in the database.
 */
function ethc_get_option( $key = null ) {

	// Exit if no key is supply.
	if ( null === $key ) {
		return;
	}

	$options = get_option( 'ethc_settings' );

	if ( isset( $options[ $key ] ) ) {
		return $options[ $key ];
	}

}

/**
 * Update the Enter Title Changer plugin option
 *
 * @since 0.4.0
 * @param string $key Option handle for the value.
 * @param string $value The user supplied value.
 * @return bool
 */
function ethc_update_option( $key = null, $value ) {
	if ( null === $key ) {
		return;
	}

	$old_options = get_option( 'ethc_settings' );
	$options     = array(
		$key => $value,
	);

	$new_options = wp_parse_args( $options, $old_options );

	return update_option( 'ethc_settings', $new_options );
}

/**
 * Retrived the saved editor title placeholder for the specified post type.
 *
 * @since 0.4.0
 * @param string $post_type WordPress post type.
 * @return array Array contains label and the editor title place holder
 */
function ethc_get_placeholder( $post_type = null ) {

	// Exit if no $post_type is supply.
	if ( null === $post_type ) {
		return;
	}

	$placeholders = get_option( 'ethc_placeholders' );

	$placeholder = $placeholders[ $post_type ]['placeholder'];

	return $placeholder;
}

/**
 * Set the Editor Title Placeholder for specified post type
 *
 * @since 0.4.0
 * @param string $post_type The Post Type.
 * @param string $placeholder New Editor Title Placeholder for the specified post type.
 * @return void
 */
function ethc_set_placeholder( $post_type, $placeholder = '' ) {

	// Exit if Post Type is not supplied.
	if ( ! isset( $post_type ) ) {
		return;
	}

	$new_placeholder = array();
	$old_placeholder = get_option( 'ethc_placeholders' );
	$post_object     = get_post_type_object( $post_type );
	$label           = isset( $post_object ) ? $post_object->label : '';

	$new_placeholder[ $post_type ] = array(
		'label'       => $label,
		'placeholder' => $placeholder,
	);

	$placeholders = wp_parse_args( $new_placeholder, $old_placeholder );

	update_option( 'ethc_placeholders', $placeholders );
}


/**
 * Delete the Custom Title Placeholder for specified post type
 *
 * @since 0.4.0
 * @param string $post_type The Post Type.
 * @return void
 */
function ethc_delete_placeholder( $post_type = null ) {

	// Exit if the post type is not set.
	if ( ! isset( $post_type ) ) {
		return;
	}

	$placeholders = ethc_get_all_placeholder();

	unset( $placeholders[ $post_type ] );

	// @todo Return the status
	update_option( 'ethc_placeholders', $placeholders );

}

/**
 * Retrive all the saved placeholder
 *
 * @since 0.4.0
 * @return array $placeholders Array of all the placeholder
 */
function ethc_get_all_placeholder() {

	$placeholders = get_option( 'ethc_placeholders' );

	return $placeholders;
}
