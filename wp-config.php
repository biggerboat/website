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

define('DB_NAME', 'biggerboat');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', '127.0.0.1');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Ht4({,C[ENBXd+@K?fPu|f?!dh?C<ROI!&mj_CPHDFP/?AM)cb J[X0piOM`eMax');
define('SECURE_AUTH_KEY',  'V.>c<xTq@B<Sxs?}vOJwYEU0Y4&%`Xw%cls`3)KN/dL|>af~h:P&z7bPabUkv@3g');
define('LOGGED_IN_KEY',    'L R>YSXn*uKOmx/?_f;a=HJ=[2^[yu>b|&[:K66v>|Yf]6l=;-f~aLt72GB>Ck7S');
define('NONCE_KEY',        'vQ7=-nQTkI_mA%m&,<9VP;v[b;x6aK{SZi1@7~8)7lkVN%K)9C[h62piwhdl;Mqb');
define('AUTH_SALT',        'AR]uA[n_EEAsWOe-fovoH];Wgs)+r|<BsR0$/}6FJB(Eh2NDp=;[xR7NPAL`D>%o');
define('SECURE_AUTH_SALT', 'Z3$6CZGr:m@@hf%lN_:Jl/H2$ N-<4=^O<A~6;Da6c:BTy6#nK8kXi$X~Y07OdZp');
define('LOGGED_IN_SALT',   'YlkzzgR= 9M1}JA x//{I,FE{]5Fi2zZ`R7jG+]i@VM`J@Eg}>tG&x3Gr39O>ceq');
define('NONCE_SALT',       '2/dK{gT,<rzpFIg]RX<i 5]H%>?ark5i-}z=V5K0+(,Z(YXpx@##C<7W~1ct3b<P');

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
