<?php
/**
 * Custom Walker for the primary nav menu
 *
 * @package FleetMonitor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FleetMonitor_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Start the element output.
	 *
	 * @param string   $output Passed by reference.
	 * @param WP_Post  $data_object Menu item data object.
	 * @param int      $depth Depth of menu item.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 * @param int      $id Current item ID.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $data_object->classes ) ? array() : (array) $data_object->classes;
		$classes[] = 'menu-item-' . $data_object->ID;

		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $data_object, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $data_object->ID, $data_object, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $data_object->attr_title ) ? $data_object->attr_title : '';
		$atts['target'] = ! empty( $data_object->target ) ? $data_object->target : '';
		if ( '_blank' === $data_object->target && empty( $data_object->xfn ) ) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $data_object->xfn;
		}
		$atts['href']         = ! empty( $data_object->url ) ? $data_object->url : '';
		$atts['aria-current'] = $data_object->current ? 'page' : '';

		$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $data_object, $args, $depth );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $data_object->title, $data_object->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $data_object, $args, $depth );

		$item_output  = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );

		// Add dropdown indicator for parent items
		if ( in_array( 'menu-item-has-children', $classes, true ) && $depth === 0 ) {
			$item_output .= '<svg class="dropdown-indicator" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 10l5 5 5-5z"/></svg>';
		}

		$item_output .= '</a>';
		$item_output .= isset( $args->after ) ? $args->after : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $data_object, $depth, $args );
	}
}
