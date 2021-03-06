<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Theme Options Field: Radio
 *
 * Radio buttons selector
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

$output = '<div class="usof-form-row-control"><ul class="usof-radio-list">';
foreach ( $field['options'] as $key => $option_title ) {
	$output .= '<li class="usof-radio">';
	$output .= '<input type="radio" id="usof_' . $field_id . '_' . $key . '" name="' . $field_id . '" value="' . esc_attr( $key ) . '"';
	$output .= checked( $value, $key, FALSE );
	$output .= '><label for="usof_' . $field_id . '_' . $key . '">';
	$output .= '<span class="usof-radio-icon"></span><span class="usof-radio-text">' . $option_title . '</span>';
	$output .= '</label></li>';
}
$output .= '</ul></div>';

echo $output;

