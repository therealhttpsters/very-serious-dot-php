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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_veryserious' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          '3}shlgyc?do6DovQ1PapqN1:sWiC~v/:QRu%,6,zXI*;Jbz`+}|-IX:+UZ^[C}MG' );
define( 'SECURE_AUTH_KEY',   'd kEFYVp5L:w&anh.YJmbd,X{YPlibjsctmaTmAq}@bcc{v&U,Wi_aEU_}Z|IjdQ' );
define( 'LOGGED_IN_KEY',     'V}n2:#k{eQ,75=@ZU+4$%Y.aqT{<9oss_/ X(]Br6!_WbMYlgw]^OK{motZu .0x' );
define( 'NONCE_KEY',         '$|pmg%&DA{>6kbxfLd2oSbEj_NRQGI&-oLl)*Fkz=gHb.|7VL@U;hj:lQmW-z,;d' );
define( 'AUTH_SALT',         'm49n?cbfWDgMzmu~g!*>gMD).IHpYIE;AM,oB(uM3Z >T`D}l;?ZP!@xa-x4qB|D' );
define( 'SECURE_AUTH_SALT',  'cRg]pD.]1?~f~(f=g|wp~DEvbhmi-@/huTe~;r-f#CI8Llx6A0=fFDGG0kq/U.6o' );
define( 'LOGGED_IN_SALT',    'Bom&m?%!-7^A<<8xtU](JOqe`:(CCyrqH~:(DGL##}Cau=r#GLyIiH9+L}#%8gjT' );
define( 'NONCE_SALT',        '>9+/:fN~k^Vycffg}vh]1UA5R!=ji?ZN<b7Xe,;5(U,(-=hP7NWMa+.x}w<R[EqK' );
define( 'WP_CACHE_KEY_SALT', 'Inr_LrTAS|>~8.{xp#O0F.0f9TiCk9gJB;un#]~~z3wZ!.VjF)fU)E#.B=xlq#lk' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
