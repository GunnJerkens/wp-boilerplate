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
 * Anything in {} is a variable completed during the init.sh script. Anything
 * that is wrapped in %% is a variable to be completed during the capistrano
 * deployment.
 */

$env_default = array(
	'name'     => 'default',
	'hostname' => 'http://{hostname_prod}',
	'debug'    => false,
	'db_name'  => '{db_prod}',
	'db_user'  => 'prod_db',
	'db_pass'  => 'password',
	'db_host'  => 'localhost',
	'password_protect' => false
);

$env_local = array_merge($env_default, array(
	'name'     => 'local',
	'hostname' => 'http://{hostname_dev}',
	'debug'    => true,
	'db_name'  => '{db_dev}',
	'db_user'  => 'root',
	'db_pass'  => ''
));

$env_staging = array_merge($env_default, array(
	'name'     => 'staging',
	'hostname' => 'http://{hostname_staging}',
	'debug'    => true,
	'db_name'  => '{db_staging}',
	'password_protect' => true
));

$production = array_merge($env_default, array(
	'name'     => 'production',
	'hostname' => 'http://{hostname_prod}'
));


if ( file_exists( dirname( __FILE__ ) . '/env_local' ) ) {

	// Local Environment
	$environment = $env_local;

	// Enable Auto Updater for OS X dev environment
	// See http://dancingengineer.com/computing/2009/07/how-to-install-wordpress-on-mac-os-x-leopard and comments
	define('FS_METHOD', 'direct');

	// Enable Uploads by Proxy
	define('UBP_LIVE_DOMAIN', $env_staging['hostname']);


} elseif ( file_exists( dirname( __FILE__ ) . '/env_staging' ) ) {

	// Staging Environment
	$environment = $env_staging;

} else {

	// Production Environment
	$environment = $production;

	// Enables caching
	define('WP_CACHE', true);

}

define('WP_ENV',   $environment['name']);
define('WP_DEBUG', $environment['debug']);
define('WP_PASSWORD_PROTECT', $environment['password_protect']);

define('WP_HOME',    $environment['hostname']);
define( 'WP_SITEURL', $environment['hostname'] . '/wp/');

define('DB_NAME',  $environment['db_name']);
define('DB_USER',  $environment['db_user']);
define('DB_HOST',  $environment['db_host']);
define('DB_PASSWORD', $environment['db_pass']);

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
{salts}

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
