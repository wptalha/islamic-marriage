<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Theme Options Field: Checkboxes
 *
 * Multiple selector
 *
 * @var $field_id string Field ID
 * @var $field array Field options
 *
 * @param $field ['title'] string Field title
 * @param $field ['description'] string Field title
 * @param $field ['options'] array List of key => title pairs
 *
 * @var $value array List of checked keys
 */

if ( ! is_array( $value ) ) {
	$value = array();
}

$output = '<div class="usof-form-row-control"><ul class="usof-checkbox-list">';
foreach ( $field['options'] as $key => $option_title ) {
	$output .= '<li class="usof-checkbox">';
	$output .= '<input type="checkbox" id="usof_' . $field_id . '_' . $key . '" name="' . $field_id . '" value="' . esc_attr( $key ) . '"';
	if ( in_array( $key, $value ) ) {
		$output .= ' checked="checked"';
	}
	$output .= '><label for="usof_' . $field_id . '_' . $key . '">';
	$output .= '<span class="usof-checkbox-icon"></span><span class="usof-checkbox-text">' . $option_title . '</span>';
	$output .= '</label></li>';
}
$output .= '</ul></div>';

echo $output;
