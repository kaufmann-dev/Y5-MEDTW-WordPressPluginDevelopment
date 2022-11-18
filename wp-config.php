<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'med05_ue01_02' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'z8A.hgu}^k[$`]F}jcg3 a6{UEAG!Qp_.=9h_Rtf(&_;T-ttWJv}SiwEneV,AM90' );
define( 'SECURE_AUTH_KEY',  'Nk4OaI}iVOuhb8uS^VgHL(U|~k|&=j%!hNKHxoc4,*h(X(fw<.i]Kj[lMB:|&/wJ' );
define( 'LOGGED_IN_KEY',    'mO|IJnL6DF+fBmH,vLnDI|GDM!:y!GRf}Vsx``L^X*UECI~NgLaUFQ *M#uX`Ov5' );
define( 'NONCE_KEY',        'qr$=v5QDryNA6uio;_HGbyh[.2}k00Dro>.{+lG{a%E1Q7#<dNV>a=md{/M{` ~1' );
define( 'AUTH_SALT',        '<*oO_&)%YJMOAOG=C@2XWQ1J}]-K$yYm1`Q(mKY36DZW:~.x&hdQs7ML_omiO)+[' );
define( 'SECURE_AUTH_SALT', '>E;gPb-DTJ<xhW(VZBX-{IN&<0)`sy7;Rs*Nmad3^vwaZrQd-[MB9!v)!81:Y36>' );
define( 'LOGGED_IN_SALT',   'cr8-R1bdA7U*$zCVhU[~Ym8X&x~X@GZMe#P+d_@}3bv-6X.9DSo`|4O/R3|}5Q*h' );
define( 'NONCE_SALT',       'qbK?s>_t*1o]$r[tz)7_[XjAaiIo6wu1PHE1V{%+v|8fUQKhkEPjtbWI^J6$@%8#' );

/**#@-*/

/**
 * WordPress database table prefix.
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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
