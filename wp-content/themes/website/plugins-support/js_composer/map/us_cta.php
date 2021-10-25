<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Overloading framework's VC shortcode mapping of: us_cta
 *
 * @var $shortcode string Current shortcode name
 * @var $config array Shortcode's config
 *
 * @param $config ['atts'] array Shortcode's attributes and default values
 */

global $us_template_directory;
require $us_template_directory . '/framework/plugins-support/js_composer/map/us_cta.php';

vc_remove_param( 'us_cta', 'btn_style' );
vc_add_param( 'us_cta', array(
	'param_name' => 'btn_style',
	'heading' => __( 'Button Style', 'us' ),
	'description' => '',
	'type' => 'dropdown',
	'value' => array(
		__( 'Solid', 'us' ) => 'solid',
		__( 'Outlined', 'us' ) => 'outlined',
	),
	'std' => $config['atts']['btn_style'],
	'edit_field_class' => 'vc_col-sm-4 vc_column',
	'weight' => 180,
) );
vc_remove_param( 'us_cta', 'btn_color' );
vc_add_param( 'us_cta', array(
	'param_name' => 'btn_color',
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
	'std' => $config['atts']['btn_color'],
	'edit_field_class' => 'vc_col-sm-4 vc_column',
	'weight' => 170,
) );
vc_remove_param( 'us_cta', 'btn_bg_color' );
vc_remove_param( 'us_cta', 'btn_text_color' );
vc_remove_param( 'us_cta', 'btn_size' );
vc_add_param( 'us_cta', array(
	'param_name' => 'btn_size',
	'heading' => __( 'Button Size', 'us' ),
	'description' => '',
	'type' => 'dropdown',
	'value' => array(
		__( 'Small', 'us' ) => 'small',
		__( 'Medium', 'us' ) => 'medium',
		__( 'Large', 'us' ) => 'large',
	),
	'std' => $config['atts']['btn_size'],
	'edit_field_class' => 'vc_col-sm-4 vc_column',
	'weight' => 140,
) );
vc_remove_param( 'us_cta', 'btn2_style' );
vc_add_param( 'us_cta', array(
	'param_name' => 'btn2_style',
	'heading' => __( 'Second Button Style', 'us' ),
	'description' => '',
	'type' => 'dropdown',
	'value' => array(
		__( 'Solid', 'us' ) => 'solid',
		__( 'Outlined', 'us' ) => 'outlined',
	),
	'std' => $config['atts']['btn2_style'],
	'dependency' => array( 'element' => 'second_button', 'not_empty' => TRUE ),
	'edit_field_class' => 'vc_col-sm-4 vc_column',
	'weight' => 80,
) );
vc_remove_param( 'us_cta', 'btn2_color' );
vc_add_param( 'us_cta', array(
	'param_name' => 'btn2_color',
	'heading' => __( 'Second Button Color', 'us' ),
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
	'std' => $config['atts']['btn2_color'],
	'dependency' => array( 'element' => 'second_button', 'not_empty' => TRUE ),
	'edit_field_class' => 'vc_col-sm-4 vc_column',
	'weight' => 70,
));
vc_remove_param( 'us_cta', 'btn2_bg_color' );
vc_remove_param( 'us_cta', 'btn2_text_color' );
vc_remove_param( 'us_cta', 'btn2_size' );
vc_add_param( 'us_cta', array(
	'param_name' => 'btn2_size',
	'heading' => __( 'Second Button Size', 'us' ),
	'description' => '',
	'type' => 'dropdown',
	'value' => array(
		__( 'Small', 'us' ) => 'small',
		__( 'Medium', 'us' ) => 'medium',
		__( 'Large', 'us' ) => 'large',
	),
	'std' => $config['atts']['btn2_size'],
	'dependency' => array( 'element' => 'second_button', 'not_empty' => TRUE ),
	'edit_field_class' => 'vc_col-sm-4 vc_column',
	'weight' => 40,
));
