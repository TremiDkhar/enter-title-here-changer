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
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_filter( 'enter_title_here', array( $this, 'new_title' ) );

	}

	/**
	 * Register setting, section and field required for the plugin.
	 *
	 * @since 0.1.1
	 * @return void
	 */
	public function register_settings() {

		register_setting( 'writing', 'ethc_settings', array( 'sanitize_callback' => array( $this, 'sanitize_data' ) ) );
		add_settings_section( 'ethc_sections', 'Enter Title Here Changer - Settings', array( $this, 'settings_section_callback' ), 'writing' );

		$posttypes = get_post_types( '', 'object' );

		// Remove post types that are not required to change title.
		unset( $posttypes['attachment'], $posttypes['revision'], $posttypes['nav_menu_item'], $posttypes['custom_css'], $posttypes['customize_changeset'], $posttypes['oembed_cache'], $posttypes['user_request'], $posttypes['wp_block'] );

		foreach ( $posttypes as $posttype ) {

			$args = array(
				'post_type' => $posttype->name,
				'label_for' => $posttype->name,
			);

			add_settings_field( 'eth_new_title_' . $posttype->name, $posttype->labels->singular_name, array( $this, 'settings_field_callback' ), 'writing', 'ethc_sections', $args );
		}

		add_settings_field( 'enter_new_title_uninstall_on_delete', 'Do you want to remove plugin data when plugin is removed?', array( $this, 'settings_uninstall' ), 'writing', 'ethc_sections', array( 'label_for' => 'ethc_settings_uninstall' ) );
	}

	/**
	 * Sanitize settings data before storing into database.
	 *
	 * @param array $settings | Raw settings data.
	 * @return array
	 */
	public function sanitize_data( $settings ) {

		$uninstall_data = isset( $settings['uninstall_on_delete'] ) ? $settings['uninstall_on_delete'] : '';

		foreach ( $settings as $setting => $value ) {
			$settings[ $setting ] = sanitize_text_field( $value );
		}

		// Restore uninstall setting.
		$settings['uninstall_on_delete'] = isset( $uninstall_data ) ? true : false;

		return $settings;
	}

	/**
	 * Added Settings section
	 *
	 * @since 0.1.1
	 * @return void
	 */
	public function settings_section_callback() {
		echo 'By default, the place holder of new post field is <kbd>Enter title here</kbd> or <kbd>Add title</kbd> in the latest WordPress. Using this settings will change to what title you want to display.';
	}

	/**
	 * Add Settings fields for different custom post type.
	 *
	 * @param array $args | Argument needed for the input field.
	 * @return void
	 */
	public function settings_field_callback( $args ) {
		?>
		<input type="text" class="regular-text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="ethc_settings[<?php echo esc_attr( $args['post_type'] ); ?>]" value="<?php echo isset( $this->settings[ $args['post_type'] ] ) ? esc_attr( $this->settings[ $args['post_type'] ] ) : ''; ?>" />
		<?php
	}

	/**
	 * Delete plugin data on plugin uninstall?
	 *
	 * @param array $args | Argument needed for the input field.
	 * @return void
	 */
	public function settings_uninstall( $args ) {
		?>
		<input type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="ethc_settings[uninstall_on_delete]" <?php checked( true, isset( $this->settings['uninstall_on_delete'] ) ? $this->settings['uninstall_on_delete'] : false ); ?> />
		<?php
	}

	/**
	 * Change the placeholder based on post type
	 *
	 * @param string $title | The default placeholder.
	 * @return string
	 */
	public function new_title( $title ) {

		$screen = get_current_screen()->post_type;

		if ( ! empty( $screen ) ) {
			$new_title = $this->settings;
			if ( ! empty( $new_title[ $screen ] ) ) {
				$title = $new_title[ $screen ];
			}
		}

		return $title;
	}

}
