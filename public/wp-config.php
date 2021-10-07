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

/**
 * Anything in {} is a variable completed during the init.sh script.
 */

$protocol = 'http';

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
  $protocol = 'https';
}

$env_default = array(
  'name'             => 'default',
  'hostname'         => $protocol.'://boilerplate.com',
  'debug'            => false,
  'db_name'          => 'boilerplate_prod',
  'db_user'          => 'boilerplate',
  'db_pass'          => 'Passw0rd!',
  'db_host'          => 'localhost',
  'cache'            => true,
  'password_protect' => false
);

$env_local = array_merge($env_default, array(
  'name'             => 'local',
  'hostname'         => $protocol.'://boilerplate.test',
  'debug'            => true,
  'db_name'          => 'boilerplate_dev',
  'db_user'          => 'root',
  'db_pass'          => '',
  'cache'            => false
));

$env_staging = array_merge($env_default, array(
  'name'             => 'staging',
  'hostname'         => $protocol.'://boilerplate.gjstage.com',
  'debug'            => true,
  'db_name'          => 'boilerplate_staging',
  'cache'            => false,
  'password_protect' => true
));

$production = array_merge($env_default, array(
  'name'             => 'production',
));


if ( file_exists( dirname( __FILE__ ) . '/../env_local' ) ) {

  // Local Environment
  $environment = $env_local;

  $local_config = file_get_contents(realpath( __DIR__ . '/../env_local'));
  if ($local_config) {
    $environment = array_merge($environment, (array) json_decode($local_config));
  }

} elseif ( file_exists( dirname( __FILE__ ) . '/../env_staging' ) ) {

  // Staging Environment
  $environment = $env_staging;

} else {

  // Production Environment
  $environment = $production;

}

define('WP_ENV',   $environment['name']);
define('WP_DEBUG', $environment['debug']);
define('WP_PASSWORD_PROTECT', $environment['password_protect']);

define('WP_HOME',    $environment['hostname']);
define('WP_SITEURL', $environment['hostname'] . '/wp/');

define('WP_CACHE', $environment['cache']);

define('DB_NAME',  $environment['db_name']);
define('DB_USER',  $environment['db_user']);
define('DB_HOST',  $environment['db_host']);
define('DB_PASSWORD', $environment['db_pass']);

/** Disable automatic updates */
define( 'WP_AUTO_UPDATE_CORE', false );

/** Disable WP file editor */
define( 'DISALLOW_FILE_EDIT', true );

/** Define file system method */
define('FS_METHOD', 'direct');

/** Define custom content directory */
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', $environment['hostname'] . '/content' );

/** Define uploads */
define( 'UPLOADS', '../shared' );

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
define('AUTH_KEY',         '._*[,RQhUMDq1Wa-:(~-R(zsWBV6H*wj<ZO+1O*>x&ZFOX?&6pF$kZUR,e4$]xTf');
define('SECURE_AUTH_KEY',  ')^vGWc80zo-C{dy[*|g^t<J+mySrZ<,_z5|2Yc(xDdw1k{Y5>N[MarWg-i-L]=q-');
define('LOGGED_IN_KEY',    ')c-NZA?:jy{G x?s%`!R,(#uU)Ih&%ob2XR.]F}b<W?@w7aj|ZL&*P1N7{mXz}<N');
define('NONCE_KEY',        ':y:,-?qcgah2`;B%TS%C.6>A-t d+976#Nrx4G#HL<NnSP:f$Q&^u3Wbu%#T-1|4');
define('AUTH_SALT',        '%N{S-k%R+R<KF|7G?R_ejuI&X*TwJ!$C_MbMmXj wR[)cBnwR<MCqb0Ed+,=bp3F');
define('SECURE_AUTH_SALT', '~UdHHJ@CeT^|9=nnn(Xo&m@eY1-DOfi2eQ^|u{0K|4T&0j9RaRJ3-`$}x)6w<CH&');
define('LOGGED_IN_SALT',   '1{X]d.SLflfvcOtN!L L.$$Gsj3l]c)0aY[!;]bB1wHD|.<TOL4qr&q+-wWLU[vo');
define('NONCE_SALT',       'w+ZU@AHCN%B;*[<![qFo>Qp=fT`}rzZ{-7(t)=}qEDR?1Naxl7&&J*P== H4FhlQ');


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'gj_';

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
 * Wordpress Post Reivisions, default is true/unlimited.
 *
 * Set the number to max amount of store revisions, or set to false to disable
 * revisions completely.
 */
define( 'WP_POST_REVISIONS', 10 );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/wp/');
require_once(ABSPATH . 'wp-settings.php');
