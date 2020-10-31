<?php
/**
 * Perform the add, update and delete the place holder
 *
 * @package ETHC
 * @subpackage Admin
 * @author Tremi Dkhar
 * @copyright Copyright (c) 2020, Tremi Dkhar
 * @since 0.1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

add_action( 'admin_init', 'ethc_handle_add_placeholder' );
/**
 * Add new placeholder to the database
 *
 * @since 0.4.0
 * @return void
 */
function ethc_handle_add_placeholder() {
	if ( ! isset( $_POST['ethc-placeholder-nonce'] ) || ! ( wp_verify_nonce( $_POST['ethc-placeholder-nonce'], 'ethc_placeholder_nonce' ) ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$post_type   = sanitize_text_field( $_POST['post-type'] );
	$placeholder = sanitize_text_field( $_POST['placeholder'] );

	ethc_set_placeholder( $post_type, $placeholder );
}

add_action( 'admin_init', 'ethc_handle_delete_placeholder' );
/**
 * Handle the delete button for the placeholder
 *
 * @since 0.4.0
 * @return void
 */
function ethc_handle_delete_placeholder() {

	// if ( ! isset( $_POST['ethc-placeholder-nonce'] ) || ! ( wp_verify_nonce( $_POST['ethc-placeholder-nonce'], 'ethc_placeholder_nonce' ) ) ) {
	// return;
	// }

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_POST['post-type'], $_POST['ethc-action'] ) && 'delete' === $_POST['ethc-action'] ) {
		ethc_delete_placeholder( $_POST['post-type'] );
	}

	if ( isset( $_POST['ajax'] ) && true === (bool) intval( $_POST['ajax'] ) ) {
		$response = array(
			'status' => 1,
		);

		echo json_encode( $response );
		wp_die();
	}

}
