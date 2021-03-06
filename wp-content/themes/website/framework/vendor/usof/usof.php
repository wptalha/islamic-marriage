<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

global $usof_directory, $usof_directory_uri, $usof_version;
if ( ! isset( $usof_directory ) ) {
	$usof_directory = get_template_directory() . '/framework/vendor/usof';
}
if ( ! isset( $usof_directory_uri ) ) {
	$usof_directory_uri = get_template_directory_uri() . '/framework/vendor/usof';
}
if ( ! isset( $usof_version ) ) {
	$theme = wp_get_theme();
	if ( is_child_theme() ) {
		$theme = wp_get_theme( $theme->get( 'Template' ) );
	}
	$usof_version = $theme->get( 'Version' );
}

if ( is_admin() ) {
	if ( ! defined( 'DOING_AJAX' ) OR ! DOING_AJAX ) {
		// Front-end interface
		require $usof_directory . '/functions/interface.php';
	} elseif ( isset( $_POST['action'] ) AND substr( $_POST['action'], 0, 5 ) == 'usof_' ) {
		// Ajax methods
		require $usof_directory . '/functions/ajax.php';
	}
}

/**
 * Get theme option or return default value
 *
 * @param string $name
 * @param mixed $default_value
 *
 * @return mixed
 */
function usof_get_option( $name, $default_value = NULL ) {
	global $usof_options;
	usof_load_options_once();

	if ( $default_value === NULL ) {
		$default_value = usof_defaults( $name );
	}

	$value = isset( $usof_options[ $name ] ) ? $usof_options[ $name ] : $default_value;

	return apply_filters( 'usof_get_option_' . $name, $value );
}

/**
 * Get default values
 *
 * @param string $key If set, retreive only one default value
 *
 * @return mixed Array of values or a single value if the $key is specified
 */
function usof_defaults( $key = NULL ) {
	$config = us_config( 'theme-options' );
	$no_values_types = array(
		'backup',
		'heading',
		'message',
		'transfer',
		'wrapper_start',
		'wrapper_end',
	);

	$selectable_types = array(
		'imgradio',
		'radio',
		'select',
		'style_scheme',
	);

	$values = array();
	foreach ( $config as &$section ) {
		if ( ! isset( $section['fields'] ) ) {
			continue;
		}
		foreach ( $section['fields'] as $field_id => &$field ) {
			if ( $key !== NULL AND $field_id != $key ) {
				continue;
			}
			if ( isset( $values[ $field_id ] ) ) {
				continue;
			}
			if ( ! isset( $field['type'] ) OR in_array( $field['type'], $no_values_types ) ) {
				continue;
			}
			if ( $field['type'] == 'style_scheme' ) {
				$options = array_keys( us_config( 'style-schemes' ) );
				if ( empty( $options ) ) {
					continue;
				}
				$field['std'] = isset( $field['std'] ) ? $field['std'] : $options[0];
				// If theme has default style scheme, it's values will be used as standard as well
				$values = array_merge( $values, us_config( 'style-schemes.' . $field['std'] . '.values' ) );
			}
			// Using first value as standard for selectable types
			if ( ! isset( $field['std'] ) AND in_array( $field['type'], $selectable_types ) ) {
				if ( isset( $field['options'] ) AND is_array( $field['options'] ) AND ! empty( $field['options'] ) ) {
					$field['std'] = key( $field['options'] );
				}
			}
			$values[ $field_id ] = isset( $field['std'] ) ? $field['std'] : '';
		}
	}

	if ( $key !== NULL ) {
		return isset( $values[ $key ] ) ? $values[ $key ] : NULL;
	}

	return $values;
}

/**
 * If the options were not loaded, load them
 */
function usof_load_options_once() {
	global $usof_options;
	if ( isset( $usof_options ) ) {
		return;
	}
	$theme = wp_get_theme();
	if ( is_child_theme() ) {
		$theme = wp_get_theme( $theme->get( 'Template' ) );
	}
	$theme_name = $theme->get( 'Name' );
	$usof_options = get_option( 'usof_options_' . $theme_name );
	if ( $usof_options === FALSE ) {
		// Trying to fetch the old good SMOF options
		$usof_options = get_option( $theme_name . '_options' );
		if ( $usof_options !== FALSE ) {
			// Disabling the old options autoload
			update_option( $theme_name . '_options', $usof_options, FALSE );
		} else {
			// Not defined yet, using default values
			$usof_options = usof_defaults();
		}
		update_option( 'usof_options_' . $theme_name, $usof_options, TRUE );
	}
}

/**
 * Save current usof options values from global $usof_options variable to database
 *
 * @param array $updated_options Array of the new options values
 */
function usof_save_options( $updated_options ) {

	if ( ! is_array( $updated_options ) OR empty( $updated_options ) ) {
		return;
	}

	global $usof_options;
	usof_load_options_once();

	do_action( 'usof_before_save', $updated_options );

	$theme = wp_get_theme();
	if ( is_child_theme() ) {
		$theme = wp_get_theme( $theme->get( 'Template' ) );
	}
	$theme_name = $theme->get( 'Name' );
	$usof_options = $updated_options;
	update_option( 'usof_options_' . $theme_name, $usof_options, TRUE );

	do_action( 'usof_after_save', $updated_options );
}

/**
 * Get uploaded image from field value
 *
 * @param string $value Upload field value in "123|full" format
 *
 * @return array [url, width, height]
 */
function usof_get_image_src( $value ) {
	if ( preg_match( '~^(\d+)(\|(.+))?$~', $value, $matches ) ) {
		// Image size
		$matches[3] = empty( $matches[3] ) ? 'full' : $matches[3];

		return wp_get_attachment_image_src( $matches[1], $matches[3] );
	} else {
		$value = str_replace( '[site_url]', site_url(), $value );
		$result = array( $value, '', '' );
	}

	return $result;
}
