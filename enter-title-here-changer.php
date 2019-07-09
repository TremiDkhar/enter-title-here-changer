<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Plugin Name: Enter Title Here Changer
 * Plugin URI: https://wordpress.org/plugins/enter-title-here-changer/
 * Description: Replace the default `Enter title here` (Legacy) or `Add Title` (Gutenberg) placeholder when creating a new post.
 * Version: 0.3.0
 * Author: Tremi Dkhar
 * Author URI: https://github.com/TremiDkhar/
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: ethc
 *
 * @package ETHC
 * @author Tremi Dkhar
 * @since 0.1.1
 * @copyright Copyright (c) 2019, Tremi Dkhar
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 0 );
}

/**
 * Main Enter_Title_Here_Changer class
 *
 * @since 0.1.0
 */
final class Enter_Title_Here_Changer {

	/**
	 * Main instance of EnterTitleHere
	 *
	 * @since 0.1.0
	 * @var object|Enter_Title_Here_Changer
	 */
	public static $instance;

	/**
	 * Start the instance of Enter_Title_Here_Changer class
	 *
	 * Insure that only one instance of Enter_Title_Here_Changer exists in memory at any one time.
	 *
	 * @since 0.1.0
	 * @static
	 * @return object|Enter_Title_Here_Changer
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self();

			self::$instance->constants();

			if ( is_admin() ) {
				include_once ETHC_PATH . 'admin/class-ethc-settings.php';
				register_activation_hook( __FILE__, array( self::$instance, 'set_default_settings' ) );
				new ETHC_Settings();
			}
		}

		return self::$instance;
	}

	/**
	 * Setup plugin constants
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function constants() {

		// Plugin Version.
		if ( ! defined( 'ETHC_VERSION' ) ) {
			define( 'ETHC_VERSION', '0.3.0' );
		}

		// Plugin URI.
		if ( ! defined( 'ETHC_URL' ) ) {
			define( 'ETHC_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Path.
		if ( ! defined( 'ETHC_PATH' ) ) {
			define( 'ETHC_PATH', plugin_dir_path( __FILE__ ) );
		}
	}

	/**
	 * Set the default options for the plugin
	 *
	 * @since 0.1.1
	 * @return void
	 */
	public function set_default_settings() {
		$default  = array(
			'uninstall_on_delete' => true,
		);
		$settings = wp_parse_args( get_option( 'ethc_settings', $default ) );
		update_option( 'ethc_settings', $settings );
	}

}

/**
 * The main function that returns EnterTitleHere instance.
 *
 * @since 0.1.0
 * @return object|Enter_Title_Here_Changer
 */
function enter_title_here_changer() {
	return Enter_Title_Here_Changer::instance();
}

// Get ETHC running.
enter_title_here_changer();
