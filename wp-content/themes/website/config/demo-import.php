<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Theme's demo-import settings
 *
 * @filter us_config_demo-import
 */
global $us_template_directory, $us_template_directory_uri;
return array(
	'main' => array(
		'title' => 'Main Demo',
		'image' => $us_template_directory_uri . '/demo-import/main-preview.jpg',
		'preview_url' => 'http://impreza.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/main-content.xml',
		'options' => $us_template_directory . '/demo-import/main-options.json',
		'nav_menu_locations' => array(
			'Impreza Header Menu' => 'us_main_menu',
			'Impreza Footer Menu' => 'us_footer_menu',
		),
		'front_page' => 'Home',
		'sliders' => array(
			$us_template_directory . '/demo-import/main-slider-home1.zip',
			$us_template_directory . '/demo-import/main-slider-home2.zip',
			$us_template_directory . '/demo-import/main-slider-home3.zip',
			$us_template_directory . '/demo-import/main-slider-portfolio.zip',
		),
	),
	'onepage' => array(
		'title' => 'One Page Demo',
		'image' => $us_template_directory_uri . '/demo-import/onepage-preview.jpg',
		'preview_url' => 'http://impreza2.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/onepage-content.xml',
		'options' => $us_template_directory . '/demo-import/onepage-options.json',
		'nav_menu_locations' => array(
			'Impreza Header Menu' => 'us_main_menu',
			'Impreza Footer Menu' => 'us_footer_menu',
		),
		'front_page' => 'Home',
	),
	'creative' => array(
		'title' => 'Creative Demo',
		'image' => $us_template_directory_uri . '/demo-import/creative-preview.jpg',
		'preview_url' => 'http://impreza3.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/creative-content.xml',
		'options' => $us_template_directory . '/demo-import/creative-options.json',
		'nav_menu_locations' => array(
			'Header Menu' => 'us_main_menu',
			'Footer Menu' => 'us_footer_menu',
		),
		'front_page' => 'Home',
		'sliders' => array(
			$us_template_directory . '/demo-import/creative-slider-main.zip',
		),
	),
	'portfolio' => array(
		'title' => 'Portfolio Demo',
		'image' => $us_template_directory_uri . '/demo-import/portfolio-preview.jpg',
		'preview_url' => 'http://impreza4.us-themes.com/',
		'content' => $us_template_directory . '/demo-import/portfolio-content.xml',
		'options' => $us_template_directory . '/demo-import/portfolio-options.json',
		'nav_menu_locations' => array(
			'Main' => 'us_main_menu',
		),
		'front_page' => 'Home',
		'sliders' => array(
			$us_template_directory . '/demo-import/portfolio-slider-home.zip',
			$us_template_directory . '/demo-import/portfolio-slider-instagram.zip',
			$us_template_directory . '/demo-import/portfolio-slider-portfolio-1.zip',
			$us_template_directory . '/demo-import/portfolio-slider-portfolio-2.zip',
			$us_template_directory . '/demo-import/portfolio-slider-portfolio-3.zip',
			$us_template_directory . '/demo-import/portfolio-slider-portfolio-4.zip',
		),
	),
);
