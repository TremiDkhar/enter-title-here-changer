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

	// if ( ! isset( $_REQUEST['ethc-placeholder-nonce'] ) || ! ( wp_verify_nonce( $_REQUEST['ethc-placeholder-nonce'], 'ethc_placeholder_nonce' ) ) ) {
	// 	return;
	// }

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_REQUEST['post-type'], $_REQUEST['ethc-action'] ) && 'edit' === $_REQUEST['ethc-action'] ) {
		$post_type   = sanitize_text_field( $_REQUEST['post-type'] );
		$placeholder = sanitize_text_field( $_REQUEST['placeholder'] );

		$status = ethc_set_placeholder( $post_type, $placeholder );

		// @todo Repeated code, Use DRY principle
		if ( isset( $_REQUEST['ajax'] ) && true === (bool) $_REQUEST['ajax'] ) {
			$response = array(
				'status' => $status,
			);

			echo wp_json_encode( $response );
			wp_die();
		}
	}
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

	if ( isset( $_REQUEST['post-type'], $_REQUEST['ethc-action'] ) && 'delete' === $_REQUEST['ethc-action'] ) {
		$status = ethc_delete_placeholder( $_REQUEST['post-type'] );

		// Return json if it is called using ajax.
		if ( isset( $_REQUEST['ajax'] ) && true === (bool) $_REQUEST['ajax'] ) {
			$response = array(
				'status' => $status,
			);

			echo wp_json_encode( $response );
			wp_die();
		}
	}

}
