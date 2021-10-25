<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Overloading framework's VC shortcode mapping of: us_logos
 *
 * @var $shortcode string Current shortcode name
 * @var $config array Shortcode's config
 *
 * @param $config ['atts'] array Shortcode's attributes and default values
 */

global $us_template_directory;
require $us_template_directory . '/framework/plugins-support/js_composer/map/us_logos.php';

vc_remove_param( 'us_logos', 'style' );
vc_add_param( 'us_logos', array(
	'param_name' => 'style',
	'heading' => __( 'Hover style', 'us' ),
	'type' => 'dropdown',
	'value' => array(
		__( 'Fade + Outline', 'us' ) => '1',
		__( 'Fade', 'us' ) => '2',
		__( 'None', 'us' ) => '3',
	),
	'std' => $config['atts']['style'],
	'weight' => 70,
) );
