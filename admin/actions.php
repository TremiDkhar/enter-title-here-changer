<?php
/**
 * @package ETHC
 * @since 0.4.0
 * @author Tremi Dkhar
 * @copyright Copyright (c) 2020, Tremi Dkhar
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

add_filter( 'plugin_action_links_' . plugin_basename( ETHC_PLUGIN_FILE ), 'ethc_add_action_links' );
/**
 * Add Settings action link to the plugin list
 *
 * @param array $links Array of action list of the plugin
 * @return void
 */
function ethc_add_action_links( $links ) {

	$action_link['settings'] = '<a href="' . admin_url( 'options-general.php?page=ethc-settings' ) . '">Settings</a>';

	return array_merge( $action_link, $links );
}
