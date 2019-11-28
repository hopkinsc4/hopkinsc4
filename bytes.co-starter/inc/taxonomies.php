<?php
/**
 * Registers custom taxonomies.
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'starter_populate_taxonomy_labels' ) ) {

	/**
	 * Generates labels for creating taxonomies.
	 * @param  string $singular  The singular name of the taxonomy.
	 * @param  string $plural    The plural name of the taxonomy.
	 * @param  array  $overrides Any labels that you wish to override.
	 * @return array             Key-Value array of taxonomy labels.\
	 */
	function starter_populate_taxonomy_labels( $singular, $plural, $overrides = array() ) {
		return shortcode_atts( array(
			'name'                       => _x( $plural, 'Taxonomy General Name', 'starter' ),
			'singular_name'              => _x( $singular, 'Taxonomy Singular Name', 'starter' ),
			'menu_name'                  => __( $plural, 'starter' ),
			'all_items'                  => __( 'All '. $plural, 'starter' ),
			'parent_item'                => __( 'Parent ' . $singular, 'starter' ),
			'parent_item_colon'          => __( 'Parent ' . $singular . ':', 'starter' ),
			'new_item_name'              => __( 'New ' . $singular . ' Name', 'starter' ),
			'add_new_item'               => __( 'Add New ' . $singular, 'starter' ),
			'edit_item'                  => __( 'Edit ' . $singular, 'starter' ),
			'update_item'                => __( 'Update ' . $singular, 'starter' ),
			'view_item'                  => __( 'View ' . $singular, 'starter' ),
			'separate_items_with_commas' => __( 'Separate ' . $plural . ' with commas', 'starter' ),
			'add_or_remove_items'        => __( 'Add or remove ' . $plural, 'starter' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'starter' ),
			'popular_items'              => __( 'Popular ' . $plural, 'starter' ),
			'search_items'               => __( 'Search ' . $plural, 'starter' ),
			'not_found'                  => __( 'Not Found', 'starter' ),
			'no_terms'                   => __( 'No ' . $plural, 'starter' ),
			'items_list'                 => __( $plural . ' list', 'starter' ),
			'items_list_navigation'      => __( $plural . ' list navigation', 'starter' ),
		), $overrides );
	}

}


add_action( 'init', 'register_starter_taxonomies', 10 );

if( ! function_exists( 'register_starter_taxonomies' ) ) {

	/**
	 * Registers all the custom taxonomies for the theme.
	 * @return null
	 */
	function register_starter_taxonomies() {

		$custom_taxonomies = array();

		/**
		 * Example Custom Taxonomy
		 * TODO: Delete this example if it's no longer needed or going to be used.
		 */
		// $custom_taxonomies['custom_taxonomy'] = array(
		// 	'post_types' => array( 'custom_post_type' ),
		// 	'args'       => array(
		// 		'labels'       => starter_populate_taxonomy_labels( __( 'Custom Taxonomy', 'starter' ), __( 'Custom Taxonomies', 'starter' ) ),
		// 		'description'  => __( 'This is a custom taxonomy.', 'starter' ),
		// 		'show_in_rest' => true, // Needed to work with Gutenberg.
		// 		'rewrite'      => array(
		// 			'slug' => 'custom-taxonomy'
		// 		)
		// 	)
		// );

		foreach( $custom_taxonomies as $taxonomy_key => $taxonomy_data ) {
			register_taxonomy( $taxonomy_key, $taxonomy_data['post_types'], $taxonomy_data['args'] );
		}
	}

}
