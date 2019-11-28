<?php
/**
 * Bytes.co Starter Accordion block.
 *
 * @package starter
 */

use Carbon_Fields\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( ! class_exists( 'AccordionBlock' ) ) {

	class AccordionBlock extends BaseBlock {

		public function __construct() {
			add_action( 'carbon_fields_register_fields', array( $this, 'register_block' ) );
		}

		protected function get_name() {
			return __( 'Content Accordion', 'starter' );
		}

		protected function get_fields() {
			return array(
					Field::make( 'text', 'heading', __( 'Heading', 'starter' ) ),
					Field::make( 'rich_text', 'content', __( 'Content', 'starter' ) ),
					Field::make( 'checkbox', 'show_content', __( 'Show content on page load', 'starter' ) )
						->set_default_value( true )
			);
		}

		protected function get_description() {
			return __( 'Create a content accordion.', 'starter' );
		}
		
		protected function get_icon() {
			return 'editor-alignleft';
		}

		public function render( $fields, $attributes, $inner_blocks) { ?>
			<?php 
			$id = sanitize_title( $fields['heading'] ); 
			if ( empty( $id ) ) {
				$id =  uniqid( 'bytesco-accordion-' );
			}
			?>
		 	<div <?php $this->class_name( $fields, $attributes ); ?>>
				<div class="card">
					<div class="card-header" id="heading-<?php echo $id; ?>">
						<h2 class="mb-0">
							<button class="btn btn-link <?php if ( ! $fields['show_content'] ) { echo 'collapsed'; } ?>" 
											type="button" 
											data-toggle="collapse" 
											data-target="#collapse-<?php echo $id; ?>" 
											aria-expanded="<?php echo ( $fields['show_content'] ) ? 'true' : 'false'; ?>" 
											aria-controls="collapse-<?php echo $id; ?>">
								<?php echo $fields['heading']; ?>
							</button>
						</h2>
					</div>
					<div id="collapse-<?php echo $id; ?>" class="collapse <?php if ( $fields['show_content'] ) { echo 'show'; } ?>" aria-labelledby="heading-<?php echo $id; ?>">
						<div class="card-body">
							<?php echo $fields['content']; ?>
						</div>
					</div>
				</div>
			</div> <?php
		}

	}

	$block = new AccordionBlock();

}
