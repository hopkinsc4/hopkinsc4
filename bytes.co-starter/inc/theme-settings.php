<?php
/**
 * Check and setup theme's default settings
 *
 * @package starter
 */

 use Carbon_Fields\Container;
 use Carbon_Fields\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'starter_setup_theme_default_settings' ) ) {
	function starter_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Latest blog posts style.
		$starter_posts_index_style = get_theme_mod( 'starter_posts_index_style' );
		if ( '' == $starter_posts_index_style ) {
			set_theme_mod( 'starter_posts_index_style', 'default' );
		}

		// Sidebar position.
		$starter_sidebar_position = get_theme_mod( 'starter_sidebar_position' );
		if ( '' == $starter_sidebar_position ) {
			set_theme_mod( 'starter_sidebar_position', 'right' );
		}

		// Container width.
		$starter_container_type = get_theme_mod( 'starter_container_type' );
		if ( '' == $starter_container_type ) {
			set_theme_mod( 'starter_container_type', 'container' );
		}
	}
}

if ( ! function_exists( 'starter_setup_theme_blocks' ) ) {
	/**
	 * Registers the blocks that this theme supports.
	 * @return null
	 */
	function starter_setup_theme_blocks() {
		$block_files = array(
			'base-block.php',
			'accordion.php'
		);
		foreach( $block_files as $block_file ) {
			$template_file = get_template_directory() . '/blocks/' . $block_file;
			if( $template_file && is_readable( $template_file ) ) {
				require_once $template_file;
			}
		}
	}
}

if ( ! function_exists( 'starter_get_theme_modes' ) ) {
	/**
	 * Gets the available theme modes for the theme.
	 * @return array 
	 */
	function starter_get_theme_modes() {
		return array(
			'development' => __( 'Development', 'starter' ),
			'production' => __( 'Production', 'starter' )
		);
	}
}

if ( ! function_exists( 'starter_setup_theme_options' ) ) {
	/**
	 * Adds a page to set theme options, such as the ability to put the theme into 
	 * development or production mode. 
	 * @return null 
	 */
	function starter_setup_theme_options() {
		Container::make( 'theme_options', __( 'Theme Options', 'starter' ) )
			->set_page_parent( 'options-general.php' )
			->add_fields( array(
				Field::make( 'select', 'bytesco_starter_theme_mode', __( 'Theme Mode', 'starter' ) )
					->set_options( starter_get_theme_modes() )
					->set_default_value( 'development' )
			) );
	}
}

if ( ! function_exists( 'starter_get_theme_mode' ) ) {
	/**
	 * Gets the mode that the theme is in.
	 * @return string 
	 */
	function starter_get_theme_mode() {
		$mode = carbon_get_theme_option( 'bytesco_starter_theme_mode' );
		if ( ! $mode ) {
			return 'development';
		}
		return $mode;
	}
}

if ( ! function_exists( 'add_theme_mode_toggle_to_admin_bar' ) ) {
	add_action( 'wp_before_admin_bar_render', 'add_theme_mode_toggle_to_admin_bar' );
	
	/**
	 * Adds adds a toggle in the admin bar to change the theme mode.
	 * @return null 
	 */
	function add_theme_mode_toggle_to_admin_bar() {
		global $wp_admin_bar;

		if ( ! is_super_admin()
			|| ! is_object( $wp_admin_bar ) 
			|| ! function_exists( 'is_admin_bar_showing' ) 
			|| ! is_admin_bar_showing() ) {
			return;
		}
		
		$current_mode = starter_get_theme_mode();

		$wp_admin_bar->add_node( array(
			'parent' => false,
			'id' => 'bytesco-starter-theme-mode',
			'title' => sprintf( __( '%s Mode', 'starter' ), starter_get_theme_modes()[$current_mode] ),
			'href' => get_admin_url( null, 'options-general.php?page=crb_carbon_fields_container_theme_options.php' ),
			'meta' => array(
				'class' => sprintf( 'bytesco-starter-theme-mode-toggle %s', $current_mode )
			)
		) );
	}
}
