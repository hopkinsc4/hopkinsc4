<?php
/**
 * Bytes.co Starter base gutenberg block.
 *
 * @package starter
 */

 use Carbon_Fields\Block;
 use Carbon_Fields\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( ! class_exists( 'BaseBlock' ) ) {

	abstract class BaseBlock {

		public function __construct() {
			add_action( 'carbon_fields_register_fields', array( $this, 'register_block' ) );
		}

		abstract protected function get_name();
		abstract protected function get_fields();
		abstract protected function get_description();
		abstract public function render( $fields, $attributes, $inner_blocks );

		protected function set_inner_blocks(){
			return false;
		}

		protected function get_preview_mode() {
			return true;
		}

		protected function get_category_slug() {
			return 'bytesco-blocks';
		}

		protected function get_category_name() {
			return __( 'Bytes.co Blocks', 'starter' );
		}

		protected function get_category_icon() {
			// Dashicon without 'dashicons-'
			return '';
		}

		protected function get_icon() {
			// Dashicon without 'dashicons-', this will be the default for all new block.
			return 'star-filled';
		}

		protected function hide_spacing_options() {
			return false;
		}

		protected function class_name( $fields, $attributes, $additional_classes = '' ) {
			$class_names = $additional_classes;
			if( ! is_array( $attributes ) ) {
				$attributes = array();
			}
			if( array_key_exists( 'className', $attributes ) && ! empty( $attributes['className'] ) ) {
				$class_names .= ' ' . $attributes['className'];
			}
			$margin_classes = [];
			if( $fields['remove_top_margin'] ) {
				$margin_classes[] = 'mt-0';
			}
			if( $fields['remove_bottom_margin'] ) {
				$margin_classes[] = 'mb-0';
			}
			printf(
				'class="bytesco-block %s %s %s"',
				esc_attr( sanitize_title( $this->get_name() ) ),
				implode( ' ', $margin_classes ),
				$class_names
			);
		}

		protected function color_palette() {
			return array();
		}

		protected function set_inner_block_position() {
			return 'below';
		}

		protected function get_adjusted_fields() {
			$fields = $this->get_fields();
			array_unshift( $fields, Field::make( 'separator', 'crb_separator', __( $this->get_name(), 'starter' ) ) );
			if( ! $this->hide_spacing_options() ) {
				$fields[] = Field::make( 'separator', 'separator', __( 'Spacing Options', 'starter' ) );
				$fields[] = Field::make( 'checkbox', 'remove_top_margin', __( 'Remove top margin', 'sstarter' ) );
				$fields[] = Field::make( 'checkbox', 'remove_bottom_margin', __( 'Remove bottom margin', 'starter' ) );
			}
			return $fields;
		}

		public function register_block() {
			Block::make( $this->get_name() )
					->add_fields( $this->get_adjusted_fields() )
					->set_category( $this->get_category_slug(), $this->get_category_name(), $this->get_category_icon() )
					->set_description( $this->get_description() )
					->set_preview_mode( $this->get_preview_mode() )
					->set_icon( $this->get_icon() )
					->set_preview_mode(  true )
					->set_render_callback( array( $this, 'render' ) )
					->set_inner_blocks( $this->set_inner_blocks() )
					->set_inner_blocks_position( $this->set_inner_block_position() );
		}
	}

}
