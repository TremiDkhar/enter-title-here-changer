<?php
if ( isset( $_POST['submit'] ) && 'Modify' === $_POST[ 'submit' ] ) {

	if ( isset( $_POST['post-type'] ) && isset( $_POST['placeholder'] ) ) {

		$post_type = sanitize_text_field( $_POST['post-type' ] );
		$placeholder = sanitize_text_field( $_POST['placeholder'] );

		ethc_set_placeholder( $post_type, $placeholder );
	}
}
