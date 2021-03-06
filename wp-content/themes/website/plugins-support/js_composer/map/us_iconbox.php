<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Overloading framework's VC shortcode mapping of: us_iconbox
 *
 * @var $shortcode string Current shortcode name
 * @var $config array Shortcode's config
 *
 * @param $config ['atts'] array Shortcode's attributes and default values
 * @param $config ['content'] string Shortcode's default content
 */

global $us_template_directory;
require $us_template_directory . '/framework/plugins-support/js_composer/map/us_iconbox.php';

vc_remove_param( 'us_iconbox', 'style' );
vc_add_param( 'us_iconbox', array(
	'param_name' => 'style',
	'heading' => __( 'Icon Style', 'us' ),
	'description' => '',
	'type' => 'dropdown',
	'value' => array(
		__( 'Simple', 'us' ) => 'default',
		__( 'Inside the Solid circle', 'us' ) => 'circle',
		__( 'Inside the Outlined circle', 'us' ) => 'outlined',
	),
	'std' => $config['atts']['style'],
	'edit_field_class' => 'vc_col-sm-6 vc_column',
	'weight' => 110,
) );
