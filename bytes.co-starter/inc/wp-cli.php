<?php
/**
 * WP-CLI Scripts 
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WP_CLI') ) {
	
	/**
	 * Sets options from the bytesco-wp-options.json file. 
	 */
	$setup_options = function( $args, $assoc_args ) {
		$site_options = json_decode( utf8_encode( file_get_contents( get_template_directory() . '/starter-wp-options.json' ) ), true );
		foreach( $site_options as $option => $value ) {
			$value = WP_CLI::colorize( '%G' . str_replace( "%", "", $value ) . "%n" );
			WP_CLI::log( sprintf( __( 'Set option %s to %s', 'starter' ), $option, $value ) );
		}
		WP_CLI::confirm( __( 'Proceed with settings these options?', 'starter' ) );
		$progress = \WP_CLI\Utils\make_progress_bar( __( 'Setting Options', 'starter' ), count( $site_options ) );
		foreach( $site_options as $option => $value ) {
			update_option( $option, $value );
			$progress->tick();
		}
		$progress->finish();
		// Save permalinks just in case they changed. 
		WP_CLI::runcommand( 'rewrite flush' );
	};
	
	WP_CLI::add_command( 'starter-setup-options', $setup_options );
	
	
	/**
	 * Installs and activates plugins from the bytesco-wp-plugins.json file. 
	 */
	$setup_plugins = function( $args, $assoc_args ) {
		$plugins = json_decode( utf8_encode( file_get_contents( get_template_directory() . '/starter-wp-plugins.json' ) ), true );
		foreach( $plugins as $name => $install ) {
			if ( $install ) {
				$value = WP_CLI::colorize( '%G' . str_replace( "%", "", $name ) . "%n" );
				WP_CLI::log( sprintf( __( 'Install plugin %s', 'starter' ), $value ) );
			}
		}
		WP_CLI::confirm( __( 'Proceed with installing these plugins?', 'starter' ) );
		foreach( $plugins as $name => $install ) {
			if ( $install ) {
				WP_CLI::runcommand( sprintf( 'plugin install %s', $name ) );
				WP_CLI::runcommand( sprintf( 'plugin activate %s', $name ) );
			}
		}
		// Save permalinks just in case they changed. 
		WP_CLI::runcommand( 'rewrite flush' );
	};
	
	WP_CLI::add_command( 'starter-setup-plugins', $setup_plugins );
	
}

