<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Theme Options diff will be recursively merged with framework's theme options via us_merge_arrays
 *
 * @var $config array Framework-based theme options config
 *
 * @return array Changed config
 */

// Replacing default values
$config['layoutoptions']['fields']['site_canvas_width']['std'] = 1240;
$config['layoutoptions']['fields']['content_width']['std'] = 70;
$config['headeroptions']['fields']['header_main_height']['std'] = 120;
$config['headeroptions']['fields']['header_main_sticky_height_1']['std'] = 60;
$config['typography']['fields']['heading_font_family']['std'] = 'Noto Sans|400,700';
$config['typography']['fields']['h1_fontsize']['std'] = '38';
$config['typography']['fields']['h2_fontsize']['std'] = '32';
$config['typography']['fields']['h3_fontsize']['std'] = '26';
$config['typography']['fields']['h4_fontsize']['std'] = '22';
$config['typography']['fields']['body_font_family']['std'] = 'Open Sans|400,700';
$config['typography']['fields']['menu_font_family']['std'] = 'Open Sans|400,700';

// Adding new fields
$config['styling']['fields'] = us_array_merge_insert( $config['styling']['fields'], array(
	'rounded_corners' => array(
		'title' => __( 'Rounded Corners', 'us' ),
		'type' => 'switch',
		'text' => __( 'Enable rounded corners of theme elements', 'us' ),
		'std' => 1,
	),
	'links_underline' => array(
		'title' => __( 'Links Underline', 'us' ),
		'type' => 'switch',
		'text' => __( 'Underline text links on hover', 'us' ),
		'std' => 1,
	),
), 'before', 'color_style' );

$config['styling']['fields'] = us_array_merge_insert( $config['styling']['fields'], array(
	'change_alt_content_colors' => array(
		'type' => 'switch',
		'text' => __( 'Change <strong>Alternate Content</strong> colors', 'us' ),
		'std' => 0,
	),
	'color_alt_content_bg' => array(
		'type' => 'color',
		'text' => __( 'Background Color', 'us' ),
		'show_if' => array( 'change_alt_content_colors', '=', TRUE ),
	),
	'color_alt_content_bg_alt' => array(
		'type' => 'color',
		'text' => __( 'Alternate Background Color', 'us' ),
		'show_if' => array( 'change_alt_content_colors', '=', TRUE ),
	),
	'color_alt_content_border' => array(
		'type' => 'color',
		'text' => __( 'Border Color', 'us' ),
		'show_if' => array( 'change_alt_content_colors', '=', TRUE ),
	),
	'color_alt_content_heading' => array(
		'type' => 'color',
		'text' => __( 'Heading Color', 'us' ),
		'show_if' => array( 'change_alt_content_colors', '=', TRUE ),
	),
	'color_alt_content_text' => array(
		'type' => 'color',
		'text' => __( 'Text Color', 'us' ),
		'show_if' => array( 'change_alt_content_colors', '=', TRUE ),
	),
	'color_alt_content_primary' => array(
		'type' => 'color',
		'text' => __( 'Primary Color', 'us' ),
		'show_if' => array( 'change_alt_content_colors', '=', TRUE ),
	),
	'color_alt_content_secondary' => array(
		'type' => 'color',
		'text' => __( 'Secondary Color', 'us' ),
		'show_if' => array( 'change_alt_content_colors', '=', TRUE ),
	),
	'color_alt_content_faded' => array(
		'type' => 'color',
		'text' => __( 'Faded Elements Color', 'us' ),
		'show_if' => array( 'change_alt_content_colors', '=', TRUE ),
	),
), 'before', 'change_subfooter_colors' );

$config['headeroptions']['fields'] = us_array_merge_insert( $config['headeroptions']['fields'], array(
	'header_socials_custom_color' => array(
		'type' => 'color',
		'title' => __( 'Custom Item Color', 'us' ),
		'std' => '#1abc9c',
		'classes' => 'cols_3_middle title_top',
	),
), 'after', 'header_socials_custom_url' );

$config['menuoptions']['fields'] = us_array_merge_insert( $config['menuoptions']['fields'], array(
	'menu_height' => array(
		'title' => __( 'Menu Height', 'us' ),
		'type' => 'switch',
		'text' => __( 'Stretch menu items to the full height of the header', 'us' ),
		'std' => 1,
	),
	'menu_hover_effect' => array(
		'title' => __( 'Menu Hover Effect', 'us' ),
		'type' => 'select',
		'options' => array(
			'none' => __( 'Simple', 'us' ),
			'underline' => __( 'Underline', 'us' ),
		),
		'std' => 'underline',
	),
), 'top' );

return $config;
