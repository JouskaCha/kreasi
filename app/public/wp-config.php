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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'Hd<CCh/$/QwU$1r!*Wm,CpYyLwo.jgG.^7Mvk]iN>m>!f=n`&ffGY >FFvW05BRl' );
define( 'SECURE_AUTH_KEY',   'FN|2q!o._JU}!(sSz4<34YCU}zs$aO3h@4Sa`_4$wpA719dC)Pe^+p^BN+g!%Dk1' );
define( 'LOGGED_IN_KEY',     'j@E5- p2g|LK_twM+n9]gj[5M]4!i;W)hkU_Xg0eF:C?3J#?tX`qG[`~7b*`({Y`' );
define( 'NONCE_KEY',         'p9q(*1mM|+M,Y|[1{MU#W5P1_y0[$m:GqP<f%_Jb%DGKr <RiRgB#UHh^w@bKq~F' );
define( 'AUTH_SALT',         '(7g^#Xe}HBQQp9MNm&},=,LbQ:O]RU!+se(&)!qTr/=f[2[I.]- hqm#s7!5P_Sc' );
define( 'SECURE_AUTH_SALT',  'E7j.7W.u#2>2#cwqHS|jt*~JbsKe>-}M)+i?JdE4|ZcCPrk:bY^W$0~#Kq:e20h]' );
define( 'LOGGED_IN_SALT',    '#yYOg{G2oY%+vd_;}MQLDH}Nb6}fm%^U!bPDJ5zGGg]`q<*M5T&xxjT/W;TBuM$l' );
define( 'NONCE_SALT',        'vG$e{q1:#9imv8PEp)XWzqps*Pxh$WoeLJd5G7P>QgTL2GC9mhZ*2-]K)ovsv3Er' );
define( 'WP_CACHE_KEY_SALT', 'fQq<=ff/uD%|i,FZuz6;iNFT?cu.a#VNW,KnFb*EPwr<y`v%TjoXm&naJ%j;KvE>' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
