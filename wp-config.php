<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wandromaha');

/** MySQL database username */
define('DB_USER', 'wandromaha');

/** MySQL database password */
define('DB_PASSWORD', 'ajxjvfidicmv');

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
define('AUTH_KEY',         '/DaG)z1`25>*)an*7l-[zR!,,#13EfG5a0~WVYI~iF!*DCyi#A1V|uW&sXS8+Z*-');
define('SECURE_AUTH_KEY',  '802=f)%169o>=`b&o2V8t+}?DXXtMF_dQN?M2Z1BZ~z|{|Fep]y/:ac[W!+|n(OH');
define('LOGGED_IN_KEY',    '&Y4Q*O{VD6|Jo6tw]rpExpeQ.[#|do!NAz8+)ZufT|bXm=-9biX7J+$Dp+!+o0=e');
define('NONCE_KEY',        'v;1:{}0OG@A|-=*lJ/8RLE+lqdjI,{ D3wBzMYM3QRJ|6%yyq;u4?J^AnW1-_,uU');
define('AUTH_SALT',        '-D-FV2Lr?YO&jl8(1Lpo}6)6d6HH^w>XxQBJ)+d%+1H!<?9[c_.2I`a6&7H7X#U2');
define('SECURE_AUTH_SALT', '`^3N.f$]Rk|KEEKNC*1n3m:Oib*-oO~L3V1sOov1iX8@D[!5*cy<(t%K]20^*#wD');
define('LOGGED_IN_SALT',   'xe*m&g,)`)V|E@a)j)C]gS5(K.C!}wE=|$$s/gID_QUi<I@Z5G;JzY;fem-fOP-t');
define('NONCE_SALT',       'w!)AU.g&*wN4<e@jmnK|=.je1:HH}i}qQPKIg1Uk?a-:907*]vK+gI-Y#[T[kZpm');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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

