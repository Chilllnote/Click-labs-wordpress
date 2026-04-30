<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
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
define( 'AUTH_KEY',         '5s.iM5OK2m{3(4KVB9T=D5CgMiD>qGGMM]aJaN$-SFUA/4HT%W@Uah)I@^GQAva[' );
define( 'SECURE_AUTH_KEY',  '_UHQl<.g5,1Z~17kd@_NjlxD1Bc:0iKJ f$gSJQg`)cvf}|~eC4JrM]->?|[{25(' );
define( 'LOGGED_IN_KEY',    '$VUEf7hRuP4M(GF=#g=oxER6<oKXaE4^u#DUCMm:%cF8fdAW,>i#9%Zl0q_eX-l+' );
define( 'NONCE_KEY',        'j[hP$2W+ ]`Hb-R/:Sb`[@bGg45>0B?340J8|CAc482V9?$,{rPA+17iZiA-Ce7E' );
define( 'AUTH_SALT',        'hmp<NW`e`J9|@;%0W/Er2x,[`E{-!Kyj9uKAra0&M;Z!4@y~Vcw]~hek2=~WWGoX' );
define( 'SECURE_AUTH_SALT', 'JFUGa:~iT0t1Dsm*qWn#v[nlPltSvnIa|7:E.f#DI]q5b?4/B@B&$mJ5k);Joq!d' );
define( 'LOGGED_IN_SALT',   'j1;GNun<44Vl6Yp0UnahnL#VW(.tZz@Gn^dbFz#d;vw4[[Xa9mSww=#(s5,tLA=A' );
define( 'NONCE_SALT',       'w]jp06/~ny|S(sVB:_K:3s+}=Lx,J*d-4F5D2&p2FP%,yI2J1@3~/tg4f^NGZZ)]' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

// define('WP_HOME', 'https://breezy-wordpress.duckdns.org');
// define('WP_SITEURL', 'https://breezy-wordpress.duckdns.org');

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
