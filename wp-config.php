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
define( 'DB_NAME', 'plugin' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

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
define( 'AUTH_KEY',         'L2}Ddbd5*O}2$T|B:iZ1a6QcWy~Ui6fxZ>YB`^iqiaj,;WqU1/WGnx3zEaOt8e8`' );
define( 'SECURE_AUTH_KEY',  'lsrdv4DlcGEl6ZfF@2j&wKT?nHGEBLg|:ls 0y^&!M:OH+)CgU<Jq!/[|JHJ_O^{' );
define( 'LOGGED_IN_KEY',    '4met|+%[$eXZB_s2!,^HAszN^.Pi b^c!kiyiCv~>+Qiev$sp|?f<i*52,g]zhc0' );
define( 'NONCE_KEY',        '6Szn)u.<;(^bGm!)[7+)6mC]z<[126dmDhpB<UpX6CzC[D0XCQ,BJ|#&87faP?9|' );
define( 'AUTH_SALT',        '>YZ(T{iNP4VNOJ*nVe1oANZbh>vql%k=q}OWcV*&!N>3#uT=K.)mR|Q~!7ONh!N^' );
define( 'SECURE_AUTH_SALT', '}pv@fv7S62+|9m$Mrm,W6e `_c#hUk2C%G<}.*fyW^e%V|65<u6A:KJ.V_>B]?/$' );
define( 'LOGGED_IN_SALT',   'a#ZDyB`XvO-2}VVy./^tJnF(XhA(@8p~J `=kOj8>8D%KJ}TLp`i [$N7Gg(=z)a' );
define( 'NONCE_SALT',       'qZf?%ZLBni 8UOH$NUKuxA.5&TUE>08KCTZNPV73!`eRzV#thU$zU)=)-gRnGMsz' );

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
