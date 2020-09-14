<?php
/**
 * Handles all the upgrade process of the plugins
 *
 * @package ETHC
 * @subpackage Admin\Upgrade
 * @author Tremi Dkhar
 * @copyright Copyright (c) 2020, Tremi Dkhar
 * @since 0.4.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

add_action( 'admin_init', 'ethc_upgrade' );
/**
 * Perform automatic database upgrades when necessary
 *
 * @since 0.4.0
 * @return void
 */
function ethc_upgrade() {

	$ethc_version = ethc_get_option( 'plugin_version' );

	// Migrate settings structure in the database.
	if ( version_compare( $ethc_version, '0.4.0', '<' ) ) {
		ethc_v0_4_0_upgrades();
	}

	if ( version_compare( ethc_get_option( 'plugin_version' ), ETHC_VERSION, '<' ) ) {

		ethc_update_option( 'plugin_version', ETHC_VERSION );

	}

}

/**
 * 0.4.0 Upgrade routine to migrate settings structure.
 *
 * @since 0.4.0
 * @return void
 */
function ethc_v0_4_0_upgrades() {

	$placeholders = array();
	$new_options  = array();
	$old_options  = get_option( 'ethc_settings' );

	$new_options['uninstall_on_delete'] = $old_options['uninstall_on_delete'];
	$new_options['plugin_version']      = ETHC_VERSION;

	unset( $old_options['uninstall_on_delete'] );

	foreach ( $old_options as $option => $value ) {
		$post_object = get_post_type_object( $option );

		// It is not necessary to change the placeholder for post type that does not show in the admin interface.
		if ( false === $post_object->show_ui ) {
			continue;
		}

		$placeholders[ $option ] = array(
			'label'       => $post_object->label,
			'placeholder' => $value,
		);
	}

	update_option( 'ethc_settings', $new_options );
	update_option( 'ethc_placeholders', $placeholders );

}
