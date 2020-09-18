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

if ( isset( $_POST['submit'] ) && 'Modify' === $_POST['submit'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Security check is not really necessary here

	if ( isset( $_POST['post-type'] ) && isset( $_POST['placeholder'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Security check is not really necessary here

		$post_type   = sanitize_text_field( $_POST['post-type'] );
		$placeholder = sanitize_text_field( $_POST['placeholder'] );

		ethc_set_placeholder( $post_type, $placeholder );
	}
}
