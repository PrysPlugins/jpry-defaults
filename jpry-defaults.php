<?php
/**
 * Plugin Name:		JPry Defaults
 * Plugin URI:		https://github.com/PrysPlugins/jpry-defaults
 * Description:		Default settings for new JPry sites.
 * Version:		1.0.0
 * Author:		Jeremy Pry
 * Author URL		http://jeremypry.com/
 * License:		GPL2
 * GitHub Plugin URI:	https://github.com/PrysPlugins/jpry-defaults
 * GitHub Branch	master
 */
 
 namespace JPry;

// Prevent direct access to this file
if ( ! defined( '\ABSPATH' ) ) {
	die( "You can't do anything by accessing this file directly." );
}

class Option_Defaults {

	/**
	 * Array of options that we're modifying.
	 *
	 * @var array
	 */
	private $options = array(
	 	'date_format',
	 	'permalink_structure',
	 	'time_format',
	 	'timezone_string',
 	);

 	/**
 	 * The current instance of this class.
 	 *
 	 * @var \JPry\Option_Defaults
 	 */
 	private static $instance = null;

 	/**
 	 * Get the single instance of this class.
 	 *
 	 * @return \JPry\Option_Defaults The instance of this class.
 	 */
 	public static function get_instance() {
 		if ( null === static::$instance ) {
 			static::$instance = new static();
 		}
 		
 		return static::$instance;
 	}
 	
 	/**
 	 * Constructor. Not much here.
 	 */
 	private __construct() {
 		// Do nothing.
 	}

	/**
	 * Add our class methods to the appropriate WordPress hooks.
	 */
 	public function setup_hooks() {
 		add_filter( 'pre_option_blog_public',                   '__return_zero' );
 		add_filter( 'pre_option_start_of_week',                 '__return_zero' );
 		add_filter( 'pre_option_uploads_use_yearmonth_folders', '__return_false' );
 		add_filter( 'pre_option_users_can_register',            '__return_zero' );

 		add_filter( 'pre_option_default_comment_status', array( $this, 'closed' ) );
 		add_filter( 'pre_option_default_ping_status',    array( $this, 'closed' ) );

 		foreach ( $this->options as $option ) {
 			add_filter( 'pre_option_' . $option, array( $this, $option ), 10, 1 );
 		}
 	}

 	/**
 	 * Mark post comments and pings closed.
 	 *
 	 * @param string $value The current value.
 	 * @return string The filtered value: "closed".
 	 */
 	public function closed( $value ) {
 		return 'closed';
 	}

 	/**
 	 * Set the date format for the site.
 	 *
 	 * @param string $value The current value.
 	 * @return string The filtered value.
 	 */
 	public function date_format( $value ) {
 		return 'F j, Y';
 	}

 	/**
 	 * Set the permalink structure for the site.
 	 *
 	 * @param string $value The default value.
 	 * @return string The filtered value.
 	 */
 	public function permalink_structure( $value ) {
 		return '/%postname%/';
 	}

 	/**
 	 * Set the time format for the site.
 	 *
 	 * @param string $value The current value.
 	 * @return string The filtered value.
 	 */
 	public function time_format( $value ) {
 		return 'H:i';
 	}

 	/**
 	 * Set the time zone for the site.
 	 *
 	 * @param string $value The current value.
 	 * @return string The filtered value.
 	 */
 	public function timezone_string( $value ) {
 		return 'America/New_York';
 	}
}

Option_Defaults::get_instance();
