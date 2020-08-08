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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'weblinhkien' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '[4lX/LO#F_?qdXb)H78.D~wb=<>,<BQ<ET<C:S_z4nI| 7mAFyEu_4By4eZrW1k2' );
define( 'SECURE_AUTH_KEY',  'ar]uw:HMTf>X3x=^/L%W_*Qi_]hXEK,<.O]Vv^5e6X16m2=,?-y*N#Mh jH|>QC%' );
define( 'LOGGED_IN_KEY',    'uVx%DR+JK,DNOPK)UBGG]PB@uv/wn*LgzI% j{j/W)A#>coLN*OiBeB:8IXVO{*W' );
define( 'NONCE_KEY',        'op%hI8lS8xlsa%S@4NKw#}eKxv#)1pOdPR<1ncPi&=`zxC1Dmu.E<MPoM8%w&bI%' );
define( 'AUTH_SALT',        '$qs=DG-4ZJ7T*PI!_Yo6NZI,.Qp#Rn./CXT$;Kvt`{CECupP^]}A6uYlEK[/ -pp' );
define( 'SECURE_AUTH_SALT', '|[bfc!@kx:,Y@Pr,~IJV4X+S#nb67/CCr;RhWcyfo.C*,]B^8TAa;TJzUrP$t&nq' );
define( 'LOGGED_IN_SALT',   '8K|SDN bAV$]C?Fs#EARB?W([nItcM&yp:W?KV6yzT1~V+V4# 2@v*9Y`e=P[$IP' );
define( 'NONCE_SALT',       'Oy2>^hlG*wM$MB.&B>XJMhy/(R-Fh-R Mq23BG25<6A63Mb%Rsk5<vvTfWN)E}UL' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
