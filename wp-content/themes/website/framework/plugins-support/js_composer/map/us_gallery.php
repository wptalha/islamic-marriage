<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Shortcode: us_gallery
 *
 * @var $shortcode string Current shortcode name
 * @var $config array Shortcode's config
 *
 * @param $config ['atts'] array Shortcode's attributes and default values
 */
vc_map( array(
	'base' => 'us_gallery',
	'name' => __( 'Image Gallery', 'us' ),
	'icon' => 'icon-wpb-images-stack',
	'category' => __( 'Content', 'us' ),
	'description' => __( 'Responsive image gallery', 'us' ),
	'weight' => 360,
	'params' => array(
		array(
			'param_name' => 'ids',
			'heading' => __( 'Images', 'us' ),
			'description' => __( 'Select images from media library.', 'us' ),
			'type' => 'attach_images',
			'std' => $config['atts']['ids'],
			'weight' => 60,
		),
		array(
			'param_name' => 'layout',
			'heading' => __( 'Layout', 'us' ),
			'description' => '',
			'type' => 'dropdown',
			'value' => array(
				__( 'Default (square thumbnails)', 'us' ) => 'default',
				__( 'Masonry (thumbnails with initial proportions)', 'us' ) => 'masonry',
			),
			'std' => $config['atts']['layout'],
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'weight' => 50,
		),
		array(
			'param_name' => 'columns',
			'heading' => __( 'Columns', 'us' ),
			'description' => '',
			'type' => 'dropdown',
			'value' => array(
				sprintf( _n( '%d column', '%d columns', 1, 'us' ), 1 ) => '1',
				sprintf( _n( '%d column', '%d columns', 2, 'us' ), 2 ) => '2',
				sprintf( _n( '%d column', '%d columns', 3, 'us' ), 3 ) => '3',
				sprintf( _n( '%d column', '%d columns', 4, 'us' ), 4 ) => '4',
				sprintf( _n( '%d column', '%d columns', 5, 'us' ), 5 ) => '5',
				sprintf( _n( '%d column', '%d columns', 6, 'us' ), 6 ) => '6',
				sprintf( _n( '%d column', '%d columns', 7, 'us' ), 7 ) => '7',
				sprintf( _n( '%d column', '%d columns', 8, 'us' ), 8 ) => '8',
				sprintf( _n( '%d column', '%d columns', 9, 'us' ), 9 ) => '9',
				sprintf( _n( '%d column', '%d columns', 10, 'us' ), 10 ) => '10',
			),
			'std' => $config['atts']['columns'],
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'weight' => 40,
		),
		array(
			'param_name' => 'orderby',
			'type' => 'checkbox',
			'value' => array( __( 'Display items in random order', 'us' ) => 'rand' ),
			( ( $config['atts']['orderby'] !== FALSE ) ? 'std' : '_std' ) => $config['atts']['orderby'],
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'weight' => 30,
		),
		array(
			'param_name' => 'indents',
			'type' => 'checkbox',
			'value' => array( __( 'Add indents between thumbnails', 'us' ) => TRUE ),
			( ( $config['atts']['indents'] !== FALSE ) ? 'std' : '_std' ) => $config['atts']['indents'],
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'weight' => 20,
		),
		array(
			'param_name' => 'el_class',
			'heading' => __( 'Extra class name', 'us' ),
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'us' ),
			'type' => 'textfield',
			'std' => $config['atts']['el_class'],
			'weight' => 10,
		),
	),
) );
vc_remove_element( 'vc_gallery' );
