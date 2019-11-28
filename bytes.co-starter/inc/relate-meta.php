<?php
/**
 * Bytes.co Starter Relate Meta (enable bidirectional Carbon Fields associations)
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( ! class_exists( 'BytesCoRelateMeta' ) ) {
	
	class BytesCoRelateMeta {

		private $field_1 = array( 'type' => '', 'sub_type' => '', 'meta_key' => '' );
		private $field_2 = array( 'type' => '', 'sub_type' => '', 'meta_key' => '' );
		private $prev_associations_1 = array();
		private $prev_associations_2 = array();
		private $prevent_work = false;

		public function __construct( $field_1, $field_2 ) {
			// Save both of the fields for reference later.
			$this->field_1['type'] = $field_1['type'];
			$this->field_2['type'] = $field_2['type'];
			$this->field_1['sub_type'] = $field_1['sub_type'];
			$this->field_2['sub_type'] = $field_2['sub_type'];
			$this->field_1['meta_key'] = $field_1['meta_key'];
			$this->field_2['meta_key'] = $field_2['meta_key'];

			// Right when the user asks to save the post, we are going to check the
			// state of the associations. Then, after carbon fields is done doing
			// everything it needs to the post, we are going to check the new values
			// to see what has changed. At that point we can do work if we need.
			add_action( "profile_update", array($this,"check_previous_state"), 5 , 1 );
			add_action( "save_post", array( $this, "check_previous_state" ), 5, 1 );
			add_action( 'edited_terms', array($this,'check_previous_state'), 5, 1 );
			add_action( "carbon_fields_post_meta_container_saved", array( $this, "check_new_state" ), 10, 1 );
			add_action( "carbon_fields_user_meta_container_saved", array( $this, "check_new_state" ), 10, 1 );
			add_action( "carbon_fields_term_meta_container_saved", array( $this, "check_new_state" ), 10, 1 );

		}
		public function check_previous_state( $input_id ) {
			if( $this->prevent_work ) {
				return;
			}
			// These may not populate with anything if we aren't saving/updating a
			// relavant item. That's OKAY though, we will just check if either of
			// these changed once it is done saving.
			// At most, ONLY 1 of them will ever populate with data. The other will be
			// an empty string because it isn't found. Or, both could be empty strings
			// if neither of them were found.
			$current_type = false;
			if( current_filter() == 'save_post' ) {
				$current_type = 'post';
			} else if( current_filter() == 'profile_update' ) {
				$current_type = 'user';
			} else if( current_filter() == 'edited_terms' ) {
				$current_type = 'term';
			}
			if( $current_type ) {
				$this->prev_associations_1 = call_user_func_array( 'carbon_get_'. $current_type .'_meta', array($input_id, $this->field_1['meta_key']) );
				$this->prev_associations_2 = call_user_func_array( 'carbon_get_'. $current_type .'_meta', array($input_id, $this->field_2['meta_key']) );
			}

		}

		public function check_new_state( $input_id ) {
			if( $this->prevent_work ) {
				return;
			}
			$current_type = false;
			if( current_filter() == 'carbon_fields_post_meta_container_saved' ) {
				$current_type = 'post';
			} else if( current_filter() == 'carbon_fields_user_meta_container_saved' ) {
				$current_type = 'user';
			} else if( current_filter() == 'carbon_fields_term_meta_container_saved' ) {
				$current_type = 'term';
			}

			if( $current_type ) {
				$new_associations_1 = call_user_func_array( 'carbon_get_'. $current_type .'_meta', array($input_id, $this->field_1['meta_key']) );
				$new_associations_2 = call_user_func_array( 'carbon_get_'. $current_type .'_meta', array($input_id, $this->field_2['meta_key']) );

				if( $this->prev_associations_1 != $new_associations_1 ) {
					$this->do_bi_directional( $input_id, $this->prev_associations_1, $new_associations_1, $this->field_1, $this->field_2 );
				}
				if( $this->prev_associations_2 != $new_associations_2 ) {
					$this->do_bi_directional( $input_id, $this->prev_associations_2, $new_associations_2, $this->field_2, $this->field_1 );
				}
			}

		}

		private function do_bi_directional( $input_id,  $prev_value, $new_value, $changed_field, $target_field ) {
			if( $this->prevent_work ) {
				return;
			}
			// If the association did not exist before hand or after, than it will
			// be an empty string. If that's the case, convert it to an empty array
			// so it is easier to find additions and subtractions.
			if( empty( $prev_value ) ) {
				$prev_value = array();
			}
			if( empty( $new_value ) ) {
				$new_value = array();
			}

			// Loop through each item in $new_value. See if they are in $prev_value. If
			// not, than add it to the additions array. Then do the same thing looping
			// instead through $prev_value, and if it isn't found in $new_value, add that
			// one to the subtractions array.
			$additions = array();
			$subtractions = array();
			foreach( $new_value as $new ) {
				$found_in_prev = false;
				foreach( $prev_value as $prev ) {
					// The 'value' key from carbon fields holds 'type:subtype:id'
					if( $prev['value'] == $new['value'] ) {
						$found_in_prev = true;
					}
				}
				if( ! $found_in_prev ) {
					$additions[] = $new;
				}
			}
			foreach( $prev_value as $prev ) {
				$also_in_new = false;
				foreach( $new_value as $new ) {
					// The 'value' key from carbon fields holds 'type:subtype:id'
					if( $new['value'] == $prev['value'] ) {
						$also_in_new = true;
					}
				}
				if( ! $also_in_new ) {
					$subtractions[] = $prev;
				}
			}

			// Now that it's known what to do, let's go and execute the additions and
			// and subtractions on the target field.
			if( ! empty( $additions ) ) {
				$this->execute_additions( $input_id, $additions, $changed_field, $target_field );
			}
			if( ! empty( $subtractions ) ) {
				$this->execute_subtractions( $input_id, $subtractions, $changed_field, $target_field );
			}
		}

		private function execute_additions( $input_id, $additions, $changed_field, $target_field ) {
			if( $this->prevent_work ) {
				return;
			}
			$this->prevent_work = true;

			// Loop through each of the additions. Take the 'id' key to get the id of
			// the post that needs to be edited. Take that post, get the current
			// associations from it using the target_fields meta key, add the new
			// association with our $post_id, type, and subtype from the changed_field,
			// then then pass it back to that association to be updated.
			foreach( $additions as $addition ) {
				$id = $addition['id'];
				$existing_associations = call_user_func_array( 'carbon_get_'.$addition['type'].'_meta',array( $id, $target_field['meta_key'] ) );

				// If there are not existing associations, than $existing_associations
				// is an empty string. Let's convert it to an array if that is the case.
				if( empty( $existing_associations ) ) {
					$existing_associations = array();
				}
				// Before we add the addition to the existing relationships, lets make
				// sure it isn't already there. (This should NEVER happen).
				$already_associated = false;
				foreach( $existing_associations as $existing ) {
					// If there is an association already with the id that is going to be
					// added, than its are already associated.
					if( $input_id == $existing['id'] ) {
						$already_associated = true;
					}
				}
				//if input id type is post, the items we are adding are users
				//if input id type is user, the items we are adding are posts
				if( ! $already_associated ) {
					// Add the post to the existing associations.
					$existing_associations[] = array(
						'value'   => $changed_field['type'].":".$changed_field['sub_type'].":".$input_id,
						'type'    => $changed_field['type'],
						'subtype' => $changed_field['sub_type'],
						'id'      => $input_id
					);

					call_user_func_array( 'carbon_set_'.$addition['type'].'_meta',array( $id, $target_field['meta_key'], $existing_associations ) );
				}
			}
			$this->prevent_work = false;
		}

		private function execute_subtractions( $input_id, $subtractions, $changed_field, $target_field ) {
			if( $this->prevent_work ) {
				return;
			}
			$this->prevent_work = true;

			// Loop through each of the subtractions. Take the 'id' key to get the id of
			// the post that needs to be edited. Take that post, get the current
			// associations from it using the target_fields meta key, and then loop
			// through them and delete the ones that match the post id.
			foreach( $subtractions as $subtraction ) {
				$id = $subtraction['id'];
				$existing_associations = call_user_func_array( 'carbon_get_'.$subtraction['type'].'_meta',array( $id, $target_field['meta_key'] ) );

				// If for some weird reason there aren't any associations (this should NEVER
				// happen) than there is nothing to do.
				if( empty( $existing_associations ) ) {
					return;
				}
				// Loop through each of the existing associations and keep track of the
				// indexes that need to be removed.
				$indexes_to_remove = array();
				foreach( $existing_associations as $index => $existing ) {
					// If the id of the association is that of the post being subtracted, than
					// it needs to be removed.
					if( $input_id == $existing['id'] ) {
						$indexes_to_remove[] = $index;
					}
				}
				// If there are associations that need to be removed, than remove
				// them from the existing associations and resave it.
				if( ! empty( $indexes_to_remove ) ) {
					foreach( $indexes_to_remove as $index ) {
						unset( $existing_associations[$index] );
					}
					// Cleanup the now empty indexes, save it.
					$existing_associations = array_values( $existing_associations );

					call_user_func_array( 'carbon_set_'.$subtraction['type'].'_meta',array( $id, $target_field['meta_key'], $existing_associations ) );
				}
			}
			$this->prevent_work = false;
		}
		
	}
	
}