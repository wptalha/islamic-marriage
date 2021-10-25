<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Overloading framework's VC shortcode mapping of: us_cform
 *
 * @var $shortcode string Current shortcode name
 *
 * @param $config ['atts'] array Shortcode's attributes and default values
 */

global $us_template_directory;
require $us_template_directory . '/framework/plugins-support/js_composer/map/us_cform.php';

vc_remove_param( 'us_cform', 'button_style' );
vc_add_param( 'us_cform', array(
	'param_name' => 'button_style',
	'heading' => __( 'Button Style', 'us' ),
	'description' => '',
	'type' => 'dropdown',
	'value' => array(
		__( 'Solid', 'us' ) => 'solid',
		__( 'Outlined', 'us' ) => 'outlined',
	),
	'std' => $config['atts']['button_style'],
	'edit_field_class' => 'vc_col-sm-6 vc_column',
	'group' => __( 'Button', 'us' ),
	'weight' => 70,
) );
vc_remove_param( 'us_cform', 'button_color' );
vc_add_param( 'us_cform', array(
	'param_name' => 'button_color',
	'heading' => __( 'Button Color', 'us' ),
	'description' => '',
	'type' => 'dropdown',
	'value' => array(
		__( 'Primary (theme color)', 'us' ) => 'primary',
		__( 'Secondary (theme color)', 'us' ) => 'secondary',
		__( 'Light (theme color)', 'us' ) => 'light',
		__( 'Contrast (theme color)', 'us' ) => 'contrast',
		__( 'Black', 'us' ) => 'black',
		__( 'White', 'us' ) => 'white',
		__( 'Pink', 'us' ) => 'pink',
		__( 'Blue', 'us' ) => 'blue',
		__( 'Green', 'us' ) => 'green',
		__( 'Yellow', 'us' ) => 'yellow',
		__( 'Purple', 'us' ) => 'purple',
		__( 'Red', 'us' ) => 'red',
		__( 'Lime', 'us' ) => 'lime',
		__( 'Navy', 'us' ) => 'navy',
		__( 'Cream', 'us' ) => 'cream',
		__( 'Brown', 'us' ) => 'brown',
		__( 'Midnight', 'us' ) => 'midnight',
		__( 'Teal', 'us' ) => 'teal',
		__( 'Transparent', 'us' ) => 'transparent',
	),
	'std' => $config['atts']['button_color'],
	'edit_field_class' => 'vc_col-sm-6 vc_column',
	'group' => __( 'Button', 'us' ),
	'weight' => 60,
) );
vc_remove_param( 'us_cform', 'button_bg_color' );
vc_remove_param( 'us_cform', 'button_text_color' );
vc_remove_param( 'us_cform', 'button_size' );
vc_add_param( 'us_cform', array(
	'param_name' => 'button_size',
	'heading' => __( 'Button Size', 'us' ),
	'description' => '',
	'type' => 'dropdown',
	'value' => array(
		__( 'Small', 'us' ) => 'small',
		__( 'Medium', 'us' ) => 'medium',
		__( 'Large', 'us' ) => 'large',
	),
	'std' => $config['atts']['button_size'],
	'edit_field_class' => 'vc_col-sm-6 vc_column',
	'group' => __( 'Button', 'us' ),
	'weight' => 30,
) );
