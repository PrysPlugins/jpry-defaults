<?php
/**
 * Plugin Name:       JPry Defaults
 * Plugin URI:        https://github.com/PrysPlugins/jpry-defaults
 * Description:       Default settings for new JPry sites.
 * Version:           1.2.0
 * Author:            Jeremy Pry
 * Author URL         https://jeremypry.com/
 * License:           GPL2
 * GitHub Plugin URI: https://github.com/PrysPlugins/jpry-defaults
 * GitHub Branch:     master
 */

namespace JPry;

// Prevent direct access to this file
defined( 'ABSPATH' ) || die();

/**
 * @return object
 */
function defaults(): object {
	static $class = null;
	if ( null !== $class ) {
		return $class;
	}

	return $class = new class() {

		/**
		 * Array of options that we're modifying.
		 *
		 * @var array
		 */
		private array $options = [
			'date_format'            => 'F j, Y',
			'default_comment_status' => 'closed',
			'default_ping_status'    => 'closed',
			'permalink_structure'    => '/%postname%/',
			'time_format'            => 'H:i',
			'timezone_string'        => 'America/New_York',
		];

		/**
		 * Add our class methods to the appropriate WordPress hooks.
		 */
		public function setup_hooks() {
			add_filter( 'pre_option_start_of_week', '__return_zero' );
			add_filter( 'pre_option_uploads_use_yearmonth_folders', '__return_false' );
			add_filter( 'pre_option_users_can_register', '__return_zero' );

			foreach ( $this->options as $option => $value ) {
				add_filter(
					"pre_option_{$option}",
					function() use ( $value ) {
						return $value;
					}
				);
			}
		}
	};
}

defaults()->setup_hooks();
