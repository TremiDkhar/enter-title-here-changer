<?php
/**
 * Admin management page for Enter Title Here settings
 *
 * @package ETHC\Admin
 * @since 0.1.0
 * @author Tremi Dkhar
 * @copyright Copyright (c) 2019, Tremi Dkhar
 */

if ( ! defined( 'ABSPATH' ) ) die(); // phpcs:ignore Generic.ControlStructures.InlineControlStructure.NotAllowed

add_action( 'admin_menu', 'enter_title_here_changer_settings' );
function enter_title_here_changer_settings() {
	add_options_page( __( 'Enter Title Here Changer Settings', 'ethc' ), 'Title Changer', 'manage_options', 'ethc-settings', 'ethc_settings' );
}

function ethc_settings() {
	echo 'Hello';
}
