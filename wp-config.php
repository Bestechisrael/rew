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
define('DB_NAME', 'dizziil7_divi_demo');

/** MySQL database username */
define('DB_USER', 'dizziil7_demo2');

/** MySQL database password */
define('DB_PASSWORD', 'dividemo');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         ']Qe?|934]58HT0C*?LZ<_1/vz-.m|<Q/$a(?ncS9&biiJrp+2_e-|~nV=qXbEIM9');
define('SECURE_AUTH_KEY',  'I+5CRg/+Ist#A>0=Qft|}f8HCEPv-c^afJMZb^p>`zDB91L^F5DqH[^YfNFW6m*E');
define('LOGGED_IN_KEY',    'Dg`*75yoB)h6YB&zy0wk$U(M18v z9lnIeY1-]:6USM-,+PPKtN27[5#Zj]Ot?/y');
define('NONCE_KEY',        ';+.+!I>Z.r-J<xJ!*ARiD,<8&4_B{8t8kHTaIeO)X;}:P36b9{QkwLJHDfcL+JoD');
define('AUTH_SALT',        '2s},^9bs%=b=U9oU*lpq.fQfz-N2mwVJO@MdR`OZbCj2>V%JVHF#@!F?SPuNw>l=');
define('SECURE_AUTH_SALT', 'd|uM:aZvvF!luPa<;Knh-{. x{GO_5zmrzk#[%v/-<XZ0H-wiG-Z/b.]Sl8^&O,^');
define('LOGGED_IN_SALT',   '?0MM>VKvH1UM6S!oGC3JJY,w#R`HA;aLz&t{AUlvhUeeNVY9#=EA|Qqz.vXE!)*N');
define('NONCE_SALT',       'sVu:`7x4-oG`@7oXE4/a(47VLZ:eYa8HL7*&cu@d_V=VS;8T#|I1{|[R^k=ZQlb$');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

define('WP_CACHE', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
