<?php
/**
 * Uninstall Enter Title Here Changer
 *
 * @package ETHC
 * @subpackage Uninstall
 * @copyright Copyright (c) 2019, Tremi Dkhar
 * @since 0.1.1
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die( 0 );
}

$ethc_settings = get_option( 'ethc_settings' );
if ( $ethc_settings['uninstall_on_delete'] ) {
	delete_option( 'ethc_settings' );
}
