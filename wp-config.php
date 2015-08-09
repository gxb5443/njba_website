<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress-db');

/** MySQL database username */
define('DB_USER', 'wordpress-user');

/** MySQL database password */
define('DB_PASSWORD', 'D0ctorW0rdpr#55');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'W#;?L}sg-{0YhmO_H+o*pto4+xJS*zms@/-=pj<pa`4>eNXaZP(9|{#_>y5|%<Ro');
define('SECURE_AUTH_KEY',  'tcVK=zL0-CI+e9L|8>([:W5=#<p(G~T?I(2Vjx|kIgs#q cz74.m+Zuu+TO>q!0y');
define('LOGGED_IN_KEY',    'J|+^cOtC/bl<KD7|@x|9p#?O9#w|~9>.f4W-OIKkY=&Mh18+7@=+bWb4i|Vg6why');
define('NONCE_KEY',        'L={O2s9frUqRP3-[n@yzdCp/ZC(~esK>!GioL@n ]&X_OP@O32+$chJLWHr!h!O5');
define('AUTH_SALT',        '|9|:gbMA^:o#EkR2+.x6qCD|^b(WYg~E:5rZ9QX(!4:y5i=|/O%|M<_dih=5G8I/');
define('SECURE_AUTH_SALT', ']y3qbj[ZZV;Azye/1},PLx`_c 78Gik-*.I`|lKN&Q+U[TI+WNTQvCTCbo2<V]jG');
define('LOGGED_IN_SALT',   'y]YXXrNZx|j>|P!YS+avF6!A$3*wVGrWOcVqiEC9sO5x3pB8OkMN$E8zxfb_.M7J');
define('NONCE_SALT',       'o_G|LZfBFR+Ay+*>#6]x&dRU+A%$iJ-D^b/[Y%j@q;Q<Ug=nfrpUoM7g=*;Ka fu');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
