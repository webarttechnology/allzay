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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'newallzaydata' );

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
define( 'AUTH_KEY',         'V64sgi|bc!tStae~Beah_aVM $RMCOuvl8ACVPD^YZvw>vF%/3#ie(]X+y?C+$hM' );
define( 'SECURE_AUTH_KEY',  ')>GMO2fybaQYgs+3rS~]0[QwTjeyyh$C!V;;A#~A?&HlX|y)cVscmAKZb-52Wr==' );
define( 'LOGGED_IN_KEY',    'nh(tNt)B*+t*89-pG;[r+zF}oZ!kN52k:f77P[`,7<}`[wY0KE70$l/t4^:3-znw' );
define( 'NONCE_KEY',        '=H<AxJravx,2SSi<7C(wQnp3J8Nv@Th=_zjq0qq$GExFI;nGrNEyS{gwW=iJuz<l' );
define( 'AUTH_SALT',        'O-=;xafe_/x5N`W&NE;pYq{/fH[tdYs@t>=63L2V*5_gya2gwTgf g,M<s[<&Sj]' );
define( 'SECURE_AUTH_SALT', '*=+*]xs3nDC+p.o*CpPszgyT$BT~j^[uuG|lOf71W)APJeaoEfYtry/2=2fpdthh' );
define( 'LOGGED_IN_SALT',   'k7SEQ9W-^7gH73FQ`^ixbF_XvMe`+ThP5}k)Z&/tDm65KKX+FKX,AIXi3S[yN#e)' );
define( 'NONCE_SALT',       'mA5&0i*EsLKfb##p8eRfeCIX8|Dl?eYx@vtb7*{Q4LUAa{m!q.s^M]Z&9V8I.uGX' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
//define( 'WP_DEBUG', true );
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
