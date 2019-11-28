<?php
/**
 * Registers custom post types.
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'starter_register_post_type' ) ) {

	/**
	 * Helper function to register a custom post type.
	 * @param  string $key      The post type key.
	 * @param  string $singular Singular name of the post type.
	 * @param  string $plural   Plural name of the post type.
	 * @param  array  $args     Post type args. See register_post_type() (or function body) for valid options.
	 * @param  array  $labels   Custom labels for new post type.
	 * @return null
	 */
	function starter_register_post_type( $key, $singular, $plural, $args, $labels ) {
		$uppercase_singular = ucfirst( $singular );
		$uppercase_plural = ucfirst( $plural );
		$lowercase_singular = strtolower( $singular );
		$lowercase_plural = strtolower( $plural );
		$labels = shortcode_atts( array(
				'name'                  => _x( $uppercase_plural, 'Post Type General Name', 'starter' ),
				'singular_name'         => _x( $uppercase_singular, 'Post Type Singular Name', 'starter' ),
				'menu_name'             => __( $uppercase_plural, 'starter' ),
				'name_admin_bar'        => __( $uppercase_singular, 'starter' ),
				'archives'              => __( $uppercase_singular . ' Archives', 'starter' ),
				'attributes'            => __( $uppercase_singular . ' Attributes', 'starter' ),
				'parent_item_colon'     => __( 'Parent ' . $uppercase_singular . ':', 'starter' ),
				'all_items'             => __( 'All ' . $uppercase_plural, 'starter' ),
				'add_new_item'          => __( 'Add New ' . $uppercase_singular, 'starter' ),
				'add_new'               => __( 'Add New', 'coneg' ),
				'new_item'              => __( 'New ' . $uppercase_singular, 'starter' ),
				'edit_item'             => __( 'Edit ' . $uppercase_singular, 'starter' ),
				'update_item'           => __( 'Update ' . $uppercase_singular, 'starter' ),
				'view_item'             => __( 'View ' . $uppercase_singular, 'starter' ),
				'view_items'            => __( 'View ' . $uppercase_plural, 'starter' ),
				'search_items'          => __( 'Search ' . $uppercase_singular, 'starter' ),
				'not_found'             => __( 'Not found', 'starter' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'starter' ),
				'featured_image'        => __( 'Featured Image', 'starter' ),
				'set_featured_image'    => __( 'Set featured image', 'starter' ),
				'remove_featured_image' => __( 'Remove featured image', 'starter' ),
				'use_featured_image'    => __( 'Use as featured image', 'starter' ),
				'insert_into_item'      => __( 'Insert into governor', 'starter' ),
				'uploaded_to_this_item' => __( 'Uploaded to this ' . $lowercase_singular, 'starter' ),
				'items_list'            => __( $uppercase_plural . ' list', 'starter' ),
				'items_list_navigation' => __( $uppercase_plural . ' list navigation', 'starter' ),
				'filter_items_list'     => __( 'Filter ' . $lowercase_plural . ' list', 'starter' )
		), $labels );
		$args = shortcode_atts( array(
				'label'               => __( $uppercase_singular, 'starter' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-star-filled',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => sanitize_title( $lowercase_plural ),
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
				'map_meta_cap'        => null,
				'show_in_rest'        => true,
				'rewrite'             => true
		), $args );

		register_post_type( $key, $args );
	}

}


add_action( 'init', 'register_starter_post_types', 10 );

if( ! function_exists( 'register_starter_post_types' ) ) {

	/**
	 * Registers all the custom post types for the theme.
	 * @return null
	 */
	function register_starter_post_types() {

		$custom_post_types = array();

		/**
		 * Example Custom Post Type
		 * TODO: Delete this example if it's no longer needed or going to be used.
		 */
		// $custom_post_types[] = array(
		// 	'key'      => 'custom_post_type',
		// 	'singular' => 'Custom Post Type',
		// 	'plural'   => 'Custom Post Types',
		// 	'args'     => array(
		// 		'menu_icon'   => 'dashicons-groups',
		// 		'supports'    => array( 'title', 'thumbnail', 'editor' ),
		// 		'has_archive' => 'custom-post-types',
		// 		'taxonomies' => array( 'custom_taxonomy' )
		// 	)
		// );

		foreach( $custom_post_types as $custom_post_type ) {
			$args = shortcode_atts( array(
					'key'      => 'custom_post_type',
					'singular' => __( 'Custom Post Type', 'starter' ),
					'plural'   => __( 'Custom Post Types', 'starter' ),
					'args'     => null,
					'labels'   => null,
			), $custom_post_type );
			starter_register_post_type( $args['key'], $args['singular'], $args['plural'], $args['args'], $args['labels'] );
		}

	}

}
