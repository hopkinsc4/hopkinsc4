<?php
/**
 * Blank content partial template.
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

starter_identify_block();

the_content();

starter_identify_block( true );
