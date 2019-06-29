<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Plugin Name: Enter Title Here Changer
 * Plugin URI: https://tremidkhar.com/plugins/enter-title-here-changer
 * Description: Replace the default 'Enter title here' in the new post
 * Version: 0.1.0
 * Author: Tremi Dkhar
 * Author URI: https://tremidkhar.com
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: ethc
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '0' );
}

class EnterTitleHereChanger {

	public static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof EnterTitleHereChanger ) ) {

			self::$instance = new EnterTitleHere();

			self::$instance->constants();

		}

		return self::$instance;
	}

	public function constants() {

		// Plugin Version.
		if ( ! defined( 'ETHC_VERSION' ) ) {
			define( 'ETHC_VERSION', '0.1.0' );
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

}

function enter_title_here_changer() {
	return EnterTitleHereChanger::instance();
}

enter_title_here_changer();
