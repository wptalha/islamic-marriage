<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'SCWORDPRESS-3238b8f7');

/** MySQL database username */
define('DB_USER', 'SCWORDPRESS-3238b8f7');

/** MySQL database password */
define('DB_PASSWORD', '4f3cb060323a12d4d286efa5bc7d9d08');

/** MySQL hostname */
define('DB_HOST', 'wordpressdb-c.hosting.stackcp.net');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'chnVFe8Jtp5dCUwRHiX9ak+qmktsemwS');
define('SECURE_AUTH_KEY',  '6XCohVH+HL+s2lbi8AO/idRcvKxd8M1/');
define('LOGGED_IN_KEY',    'UlwNgBYI6b1AjE5MpEs3xs2AU+tyTv18');
define('NONCE_KEY',        'L4QBV3LJOQ4QZ7Ys98XnsZkxB9IbRn3x');
define('AUTH_SALT',        'dfio4Q5Ycn8iHMTt2/TIatlem08XuTys');
define('SECURE_AUTH_SALT', '7GGgxAvZbNJsPI9t1qDd5uhfz9GuaBoh');
define('LOGGED_IN_SALT',   'y10LKSZxyhx1z3pLmgoqA1sdmL/08abn');
define('NONCE_SALT',       'Ux2UWLyGkNTbBHqK20CAmhxK1Up6WMUK');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hk_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
