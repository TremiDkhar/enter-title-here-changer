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
 * Retrived the saved editor title placeholder for the specified post type.
 *
 * @param string $post_type WordPress post type.
 * @return array Array contains label and the editor title place holder
 */
function ethc_get_placeholder( $post_type = null ) {

	// Exit if no $post_type is supply.
	if ( null === $post_type ) {
		return;
	}

	$placeholders = get_option( 'ethc_placeholders' );

	$placeholder = $placeholders( $post_type );

	return $placeholder;
}
