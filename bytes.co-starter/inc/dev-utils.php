<?php
/**
 * Bytes.co Starter utilities to help with development.
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'starter_identify_block' ) ) {
	/**
	 * Creates HTML comments for identifying the the file code is being
	 * generated from.
	 * @param  boolean $end If the function is being called at the end of file.
	 * @return null
	 */
	function starter_identify_block( $end = false ) {
		if( apply_filters( 'starter_identify_block', true ) ) {
			$backtrace = debug_backtrace();
			$call = $backtrace[0];
			// trim to themes directory
			$root = get_theme_root() . '/';
			if( substr( $call['file'], 0, strlen( $root ) ) == $root ) {
				$fname = substr( $call['file'], strlen( $root ) );
			} else {
				$fname = $call['file'];
			}
			$prefix = ( $end ) ? "END" : "START";
			echo "\n<!-- @@ " . $prefix . " CODE BLOCK: " . $fname . " LINE: " . $call['line'] . "-->\n";
		}
	}
}

if ( ! function_exists( 'disable_block_identification_in_production') ) {
	add_filter( 'starter_identify_block', 'disable_block_identification_in_production', 10, 1 );
	
	/**
	 * Disables block identification in production mode. 
	 * @param  boolean $development_mode The current setting.
	 * @return boolean                   Wether to identify blocks or not.
	 */
	function disable_block_identification_in_production( $identify_blocks ) {
		return starter_get_theme_mode() == 'development';
	}
}
