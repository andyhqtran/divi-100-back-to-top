<?php

/**
* @package Custom_Back_To_Top
* @version 0.0.1
*/

/*
* Plugin Name: Custom Back To Top
* Plugin URI: https://elegantthemes.com/
* Description: This plugin gives you the option to choose between 4 different back to top variations.
* Author: Elegant Themes
* Version: 0.0.1
* Author URI: http://elegantthemes.com
* License: GPL3
*/

/**
 * Load Divi 100 Setup
 */
require_once( plugin_dir_path( __FILE__ ) . '/divi-100-setup/divi-100-setup.php' );

/**
 * Load Custom Back To Top
 */
class ET_Divi_100_Custom_Back_To_Top {
	/**
	* Unique instance of plugin
	*/
	public static $instance;
	public $main_prefix;
	public $plugin_slug;
	public $plugin_id;
	public $plugin_prefix;
	protected $settings;
	protected $utils;

	/**
	* Gets the instance of the plugin
	*/
	public static function instance(){
		if ( null === self::$instance ){
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	* Constructor
	*/
	private function __construct(){
		$this->main_prefix   = 'et_divi_100_';
		$this->plugin_slug   = 'custom_back_to_top';
		$this->plugin_id     = "{$this->main_prefix}{$this->plugin_slug}";
		$this->plugin_prefix = "{$this->plugin_id}-";
		$this->settings      = maybe_unserialize( get_option( $this->plugin_id ) );
		$this->utils         = new Divi_100_Utils( $this->settings );

		// Initialize if Divi is active
		if ( et_divi_100_is_active() ) {
			$this->init();
		}
	}

	/**
	* Hooking methods into WordPress actions and filters
	*
	* @return void
	*/
	private function init(){
		add_action( 'wp_enqueue_scripts',    array( $this, 'enqueue_frontend_scripts' ) );
		add_filter( 'body_class',            array( $this, 'body_class' ) );

		if ( is_admin() ) {
			$settings_args = array(
				'plugin_id'       => $this->plugin_id,
				'preview_dir_url' => plugin_dir_url( __FILE__ ) . 'preview/',
				'title'           => __( 'Custom Back To Top' ),
				'description'     => __( 'Nullam quis risus eget urna mollis ornare vel eu leo.' ),
				'fields' => array(
					array(
						'type'                 => 'select',
						'preview_prefix'       => 'style-',
						'preview_height'       => 300,
						'id'                   => 'style',
						'label'                => __( 'Select Style' ),
						'description'          => __( 'Proper description goes here' ),
						'options'              => $this->get_styles(),
						'sanitize_callback'    => 'sanitize_text_field',
					),
				),
				'button_save_text' => __( 'Save Changes' ),
			);

			new Divi_100_Settings( $settings_args );
		}
	}

	/**
	* List of valid styles
	* @return void
	*/
	function get_styles() {
		return apply_filters( $this->plugin_prefix . 'styles', array(
			''    => __( 'Default' ),
			'1'   => __( 'One' ),
			'2'   => __( 'Two' ),
			'3'   => __( 'Three' ),
			'4'   => __( 'Four' ),
			'5'   => __( 'Five' ),
			'6'   => __( 'Six' ),
		) );
	}

	/**
	* Add specific class to <body>
	* @return array
	*/
	function body_class( $classes ) {
		// Get selected style
		$selected_style = $this->utils->get_value( 'style' );

		// Assign specific class to <body> if needed
		if ( '' !== $selected_style ) {
			$classes[] = esc_attr(  $this->plugin_prefix . '-style-' . $selected_style );
		}

		return $classes;
	}

	/**
	* Load front end scripts
	* @return void
	*/
	function enqueue_frontend_scripts() {
		wp_enqueue_style( 'custom-back-to-top', plugin_dir_url( __FILE__ ) . 'css/style.css' );
		wp_enqueue_script( 'custom-back-to-top', plugin_dir_url( __FILE__ ) . 'js/scripts.js', array( 'jquery', 'divi-custom-script' ), '0.0.1', true );
	}
}
ET_Divi_100_Custom_Back_To_Top::instance();