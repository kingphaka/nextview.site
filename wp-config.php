<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'u643464181_nextviewdb' );

/** MySQL database username */
define( 'DB_USER', 'u643464181_nextviewuser' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Fertilike013' );

/** MySQL hostname */
define( 'DB_HOST', 'mysql' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '[+>I!`IiimenMg)9Pnd57s.[Q#d4KzoApRM>|:xjknLCH[wX({b5z>cXci+s79{k' );
define( 'SECURE_AUTH_KEY',   'hbc1%-D6zO$)`#?E%hVh3)d@&.t8*.K7Y?!O!T@y(Y:Hr*P<3HYF-t~xWh,pI*ux' );
define( 'LOGGED_IN_KEY',     ':Y_!oJ_-]tYiCx9{R1$v~8}.W&AkV{(K/SW]CXf!-q8P)=6+6>K^^-dQq u<ia*1' );
define( 'NONCE_KEY',         'ctEUwU/y+IBtt6qtfLTq!@vE.aTC =O94Q1rwzT@/w(DvwmkTPehlPi44fm-w:qf' );
define( 'AUTH_SALT',         'e)-<!K~zKY+bd)0is0OU7B;ku!Hs=u>ufSs.STVzKk/?=`:Nt,J=}!7 %c*IXiY/' );
define( 'SECURE_AUTH_SALT',  '9_d.VT yr#)S)oxZw|r>/&wVzvMx]`?P?L1h317o=.k=X.GUkKXJNgnKKNX0=%7D' );
define( 'LOGGED_IN_SALT',    '[CIRU1Nr:,}!bx#(xJ[R#*V[yuf9vKDC/+.Cqn9YMCMF<9GUCR(P|fw1dFOyFg`;' );
define( 'NONCE_SALT',        '7&|vD=dO@blp?oTeNhX[x.?<oW xG*eyW.9i e=qi+iCPLe`R!0[C;f?8[eiyAlG' );
define( 'WP_CACHE_KEY_SALT', '=OMU$N5tOzGYL`#g8/*<bE_))?PnL3$:k[#3zY#6DkUS$=h:<Z@|vW(BgY14j]vc' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
