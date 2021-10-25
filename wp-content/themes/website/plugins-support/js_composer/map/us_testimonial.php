<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Overloading framework's VC shortcode mapping of: us_testimonial
 *
 * @var $shortcode string Current shortcode name
 * @var $config array Shortcode's config
 *
 * @param $config ['atts'] array Shortcode's attributes and default values
 */

global $us_template_directory;
require $us_template_directory . '/framework/plugins-support/js_composer/map/us_testimonial.php';

vc_remove_param( 'us_testimonial', 'style' );
vc_add_param( 'us_testimonial', array(
	'param_name' => 'style',
	'heading' => __( 'Quote Style', 'us' ),
	'type' => 'dropdown',
	'value' => array(
		sprintf( __( 'Style %d', 'us' ), 1 ) => '1',
		sprintf( __( 'Style %d', 'us' ), 2 ) => '2',
		sprintf( __( 'Style %d', 'us' ), 3 ) => '3',
		sprintf( __( 'Style %d', 'us' ), 4 ) => '4',
	),
	'std' => $config['atts']['style'],
	'weight' => 70,
) );
