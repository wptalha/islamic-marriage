<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Shortcodes config
 *
 * @var $config array Framework-based shortcodes config
 *
 * @filter us_config_shortcodes
 */

global $us_template_directory;

$config['vc_row']['atts']['columns_type'] = 'small';

$config['vc_row_inner']['atts']['columns_type'] = 'small';

$config['us_blog']['custom_vc_map'] = $us_template_directory . '/plugins-support/js_composer/map/us_blog.php';

$config['us_btn']['atts']['style'] = 'solid';
$config['us_btn']['custom_vc_map'] = $us_template_directory . '/plugins-support/js_composer/map/us_btn.php';

$config['us_cform']['atts']['button_style'] = 'solid';
$config['us_cform']['custom_vc_map'] = $us_template_directory . '/plugins-support/js_composer/map/us_cform.php';

$config['us_social_links']['atts']['style'] = 'desaturated';

$config['us_cta']['atts']['btn_style'] = 'solid';
$config['us_cta']['atts']['btn2_style'] = 'solid';
$config['us_cta']['custom_vc_map'] = $us_template_directory . '/plugins-support/js_composer/map/us_cta.php';

$config['us_iconbox']['custom_vc_map'] = $us_template_directory . '/plugins-support/js_composer/map/us_iconbox.php';

$config['us_logos']['custom_vc_map'] = $us_template_directory . '/plugins-support/js_composer/map/us_logos.php';

$config['us_pricing']['items_atts']['btn_style'] = 'solid';
$config['us_pricing']['custom_vc_map'] = $us_template_directory . '/plugins-support/js_composer/map/us_pricing.php';

$config['us_testimonial']['custom_vc_map'] = $us_template_directory . '/plugins-support/js_composer/map/us_testimonial.php';

$config['us_person']['atts']['layout'] = 'toplinks';
$config['us_person']['custom_vc_map'] = $us_template_directory . '/plugins-support/js_composer/map/us_person.php';

return $config;
