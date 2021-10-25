<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Contact form configuration
 *
 * @var $config array Framework-based theme options config
 *
 * @filter us_config_cform
 */

// Using placeholders instead of titles
return us_array_merge( $config, array(
	'fields' => array(
		'name' => array(
			'title' => '',
			'placeholder' => __( 'Name', 'us' ),
		),
		'email' => array(
			'title' => '',
			'placeholder' => __( 'Email', 'us' ),
		),
		'phone' => array(
			'title' => '',
			'placeholder' => __( 'Phone Number', 'us' ),
		),
		'message' => array(
			'title' => '',
			'placeholder' => __( 'Message', 'us' ),
		),
	),
) );
