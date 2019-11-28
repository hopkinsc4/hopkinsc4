<?php
/**
 * Custom fields
 *
 * @package starter
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_action( 'carbon_fields_register_fields', 'crb_attach_custom_fields_and_theme_options' );

if( ! function_exists( 'crb_attach_custom_fields_and_theme_options' ) ) {

	/**
	 * Register Carbon Fields custom fields and theme options.
	 * @return null
	 */
	function crb_attach_custom_fields_and_theme_options() {

		// Add some default options to the theme. 
		starter_setup_theme_options();

    /**
     * Add Carbon Fields containers here.
     * TODO: Delete this comment when it is no longer needed.
     */

	}

}
