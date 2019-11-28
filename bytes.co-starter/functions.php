<?php
/**
 * Bytes.co Starter functions and definitions
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$starter_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/jetpack.php',                         // Load Jetpack compatibility file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
	'/woocommerce.php',                     // Load WooCommerce functions.
	'/editor.php',                          // Load Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
	'/dev-utils.php',                       // Utilities to make theme dev easier.
	'/relate-meta.php',                     // Create bidirectional relationships with Carbon Fields.
	'/better-excerpt.php',                  // Better excerpt handling. 
	'/post-types.php',                      // Register custom post types.
	'/taxonomies.php',                      // Register custom taxonomies.
  '/custom-fields.php',                   // Add custom fields and theme options using Carbon Fields.
	'/shortcodes.php',                      // Add custom shortcodes
	'/wp-cli.php'                           // WP CLI Scripts 
);

foreach ( $starter_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
