<?php
/**
 * Custom Walker for the primary nav menu with Mega Menu support.
 *
 * Any top-level menu item that has the CSS class "mega-menu" set in
 * Appearance → Menus → CSS Classes will render its children inside a
 * wide multi-column "mega-dropdown" panel instead of the default narrow
 * sub-menu.  Second-level items whose class starts with "mega-col" act
 * as column wrappers; all other second-level items are rendered as normal
 * links inside the current column.
 *
 * @package FleetLink
 */

if ( ! defined( 'ABSPATH' ) ) {
exit;
}

class FleetLink_Walker_Nav_Menu extends Walker_Nav_Menu {

/**
 * Whether the item at depth-0 currently being output has mega-menu class.
 *
 * @var bool
 */
private $is_mega = false;

// ------------------------------------------------------------------
// start_lvl  – opening <ul> of a sub-menu
// ------------------------------------------------------------------
public function start_lvl( &$output, $depth = 0, $args = null ) {
$indent = str_repeat( "\t", $depth );
if ( 0 === $depth && $this->is_mega ) {
$output .= "\n{$indent}<ul class=\"sub-menu mega-dropdown\" role=\"menu\">\n";
} else {
$output .= "\n{$indent}<ul class=\"sub-menu\" role=\"menu\">\n";
}
}

// ------------------------------------------------------------------
// end_lvl  – closing </ul>
// ------------------------------------------------------------------
public function end_lvl( &$output, $depth = 0, $args = null ) {
$indent  = str_repeat( "\t", $depth );
$output .= "\n{$indent}</ul>\n";
}

// ------------------------------------------------------------------
// start_el  – opening <li> + link
// ------------------------------------------------------------------
public function start_el( &$output, $data_object, $depth = 0, $args = null, $id = 0 ) {
$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

$classes   = empty( $data_object->classes ) ? array() : (array) $data_object->classes;
$classes[] = 'menu-item-' . $data_object->ID;

// Track whether the top-level parent is a mega-menu item.
if ( 0 === $depth ) {
$this->is_mega = in_array( 'mega-menu', $classes, true );
}

// For depth-1 items inside a mega-dropdown that are column-header
// markers (class "mega-col"), render as a column wrapper.
if ( 1 === $depth && $this->is_mega && in_array( 'mega-col', $classes, true ) ) {
$output .= $indent . '<li class="mega-col-wrap">';

// Column heading from item title
$title   = apply_filters( 'the_title', $data_object->title, $data_object->ID );
$output .= '<span class="mega-col-hd">' . esc_html( $title ) . '</span>';
// Note: we skip the <a> for column-header items
$output .= apply_filters( 'walker_nav_menu_start_el', '', $data_object, $depth, $args );
return;
}

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

// Build icon SVG for known mega-menu sub-items by checking URL slug
$icon_svg = '';
if ( 1 === $depth && $this->is_mega ) {
$icon_svg = $this->get_mega_item_icon( $data_object->url, $classes );
}

$item_output  = isset( $args->before ) ? $args->before : '';
$item_output .= '<a' . $attributes . '>';

if ( $icon_svg ) {
$item_output .= '<span class="mega-item-icon" aria-hidden="true">' . $icon_svg . '</span>';
}

$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );

// Dropdown chevron for top-level parents
if ( in_array( 'menu-item-has-children', $classes, true ) && 0 === $depth ) {
$item_output .= '<svg class="dropdown-indicator" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 10l5 5 5-5z"/></svg>';
}

$item_output .= '</a>';
$item_output .= isset( $args->after ) ? $args->after : '';

$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $data_object, $depth, $args );
}

// ------------------------------------------------------------------
// end_el  – closing </li>
// ------------------------------------------------------------------
public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
$output .= "</li>\n";
}

// ------------------------------------------------------------------
// Helper – return an inline SVG icon based on the menu item URL/class.
// ------------------------------------------------------------------
private function get_mega_item_icon( $url, $classes ) {
$slug = basename( rtrim( (string) $url, '/' ) );

$icons = array(
'gps-tracking'        => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="9" stroke-dasharray="2 3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg>',
'driver-behavior'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7"/><path d="M17 14l2 2 4-4" stroke-linecap="round"/></svg>',
'zachowanie-kierowcy' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.58-7 8-7s8 3 8 7"/><path d="M17 14l2 2 4-4" stroke-linecap="round"/></svg>',
'tachografy'          => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="6" width="18" height="13" rx="2"/><path d="M3 11h18M8 6V4M16 6V4"/><circle cx="12" cy="15" r="2"/></svg>',
'telematyka-wideo'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="6" width="15" height="12" rx="2"/><polygon points="22,7 17,10 17,14 22,17"/></svg>',
'serwis'              => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3-3a6 6 0 01-7.4 7.4l-6.3 6.3a2.1 2.1 0 01-3-3L10.3 9a6 6 0 017.4-7.4l-3 3z"/></svg>',
'optymalizacja-kosztow' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>',
'geofencing'          => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>',
'raporty'             => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 17v-6M12 17v-3M15 17v-9"/><rect x="3" y="3" width="18" height="18" rx="2"/></svg>',
'transport'           => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
'taxi'                => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3"/><rect x="9" y="11" width="14" height="10" rx="1"/><circle cx="12" cy="21" r="1"/><circle cx="20" cy="21" r="1"/></svg>',
'budownictwo'         => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
'leasing'             => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>',
'blog'                => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>',
'dokumentacja'        => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
'api'                 => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
);

// Fallback: check if any class matches
foreach ( $classes as $c ) {
if ( isset( $icons[ $c ] ) ) {
return $icons[ $c ];
}
}

return isset( $icons[ $slug ] ) ? $icons[ $slug ] : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>';
}
}
