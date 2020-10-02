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

// @todo Wrap in some sort of function or class
if ( isset( $_POST['submit'] ) && 'Modify' === $_POST['submit'] ) {

	if ( isset( $_POST['post-type'] ) && isset( $_POST['placeholder'] ) ) {

		$post_type   = sanitize_text_field( $_POST['post-type'] );
		$placeholder = sanitize_text_field( $_POST['placeholder'] );

		ethc_set_placeholder( $post_type, $placeholder );
	}
}

if ( isset( $_GET['post-type'] ) && 'delete' === $_GET['ethc-action'] ) {
	ethc_delete_placeholder( $_GET['post-type'] );
}
