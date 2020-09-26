<?php
/**
 * Admin management page for Enter Title Here settings
 *
 * @package ETHC
 * @subpackage Admin
 * @since 0.1.0
 * @author Tremi Dkhar
 * @copyright Copyright (c) 2019, Tremi Dkhar
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Enter Title Here Chnager Main Settings Class
 *
 * @since 0.2.0
 */
class ETHC_Settings {

	/**
	 * Plugin settings data
	 *
	 * @access protected
	 * @since 0.2.0
	 * @var array
	 */
	protected $settings = array();

	/**
	 * Constructor.
	 *
	 * Set up the setting page and apply the action and filter hook
	 *
	 * @since 0.2.0
	 */
	public function __construct() {

		$this->settings = get_option( 'ethc_settings' );
		add_action( 'admin_menu', array( $this, 'register_setting_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_javascript' ) );
		add_filter( 'enter_title_here', array( $this, 'new_editor_title_placeholder' ) );
	}

	/**
	 * Register setting, section and field required for the plugin.
	 *
	 * @since 0.1.1
	 * @return void
	 */
	public function register_setting_page() {

		add_submenu_page( 'options-general.php', 'Enter Title Here Changer Settings', 'ETHC Settings', 'manage_options', 'ethc-settings', array( $this, 'settings_page' ) );

	}

	/**
	 * Enqueue JavaScript
	 *
	 * @since 0.4.0
	 * @return void
	 */
	public function enqueue_javascript() {
		wp_enqueue_script( 'sweetalert', ETHC_URL . 'admin/js/sweetalert2.min.js', array(), ETHC_VERSION, true );
		wp_enqueue_script( 'ethc', ETHC_URL . 'admin/js/script.js', array(), ETHC_VERSION, true );
	}

	/**
	 * Create plugin settings page
	 *
	 * @since 0.4.0
	 * @return void
	 */
	public function settings_page() {
		if ( isset( $_GET['ethc-action'] ) ) {
			require_once ETHC_PATH . 'admin/placeholder-action.php';
		}
		require_once ETHC_PATH . 'admin/ethc-settings-page.php';
	}

	/**
	 * Change the placeholder based on post type
	 *
	 * @param string $title | The default placeholder.
	 * @return string
	 */
	public function new_editor_title_placeholder( $title ) {

		$current_post_type = get_current_screen()->post_type;
		$placeholders      = ethc_get_all_placeholder();

		if ( array_key_exists( $current_post_type, $placeholders ) ) {
			$title = ethc_get_placeholder( $current_post_type );
		}

		return $title;
	}

}
