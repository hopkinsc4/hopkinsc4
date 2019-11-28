<?php
/**
 * Bytes.co Starter enqueue scripts
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'starter_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function starter_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		wp_enqueue_style( 'starter-styles', starter_script_file( '/css/theme.css', '/css/theme.min.css' ), array(), $css_version );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'bootstrap4', starter_script_file( '/js/bootstrap.bundle.js', '/js/bootstrap.bundle.min.js' ), array( 'jquery', ), '4.3.1', true );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script( 'starter-scripts', starter_script_file( '/js/theme.js', '/js/theme.min.js' ), array( 'jquery', 'bootstrap4' ), $js_version, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // endif function_exists( 'starter_scripts' ).

add_action( 'wp_enqueue_scripts', 'starter_scripts' );


if ( ! function_exists( 'starter_admin_scripts' ) ) {
	/**
	 * Load custom styles into the admin area.
	 */
	function starter_admin_scripts() {
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/custom-editor-style.css' );
		wp_register_style( 'starter-styles', get_template_directory_uri() . '/css/custom-editor-style.css', false, $css_version );
		wp_enqueue_style( 'starter-styles' );
	}
}

add_action( 'admin_enqueue_scripts', 'starter_admin_scripts' );


if ( ! function_exists( 'starter_script_file' ) ) {
	/**
	 * Gets the correct file based on the mode that the theme is in. Both the origional and minified
	 * should share the same base directory uri.
	 * @param  string $original          The origional filename ex. /js/scripts.js
	 * @param  string $minified           The minified filename ex. /js/scripts.min.js
	 * @param  string $base_directory_uri Where do the scripts live?
	 * @return string                     The full script file uri
	 */
	function starter_script_file( $original, $minified = null, $base_directory_uri = null ) {
		$minified = $minified == null ? $original : $minified;
		$base_directory_uri = $base_directory_uri == null ? get_template_directory_uri() : $base_directory_uri;
		$theme_mode = carbon_get_theme_option( 'bytesco_starter_theme_mode' );
		$filename = $base_directory_uri . $original;
		if ( starter_get_theme_mode() == 'production' ) {
			$filename = $base_directory_uri . $minified;
		}
		return $filename;
	}
}
