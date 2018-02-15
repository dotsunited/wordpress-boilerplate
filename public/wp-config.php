<?php

require __DIR__ . '/../vendor/autoload.php';

Env::init();

$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();
$dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME']);

// ---

define('WP_ENV', env('WP_ENV') ?: 'production');

if ('development' === WP_ENV) {
    define('SAVEQUERIES', true);
    define('WP_DEBUG', true);
    define('SCRIPT_DEBUG', true);
} else {
    ini_set('display_errors', 0);
    define('WP_DEBUG_DISPLAY', false);
    define('SCRIPT_DEBUG', false);
}

// ---

define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL') ?: WP_HOME . '/wp');

// ---

define('WP_ALLOW_MULTISITE', env('WP_ALLOW_MULTISITE') ?: true);
define('MULTISITE', env('MULTISITE') ?: false);

if (MULTISITE) {
    define('SUBDOMAIN_INSTALL', env('SUBDOMAIN_INSTALL') ?: false);
    define('DOMAIN_CURRENT_SITE', env('DOMAIN_CURRENT_SITE') ?: str_replace(['https://', 'http://'], '', WP_HOME));
    define('PATH_CURRENT_SITE', env('PATH_CURRENT_SITE') ?: '/');
    define('SITE_ID_CURRENT_SITE', env('SITE_ID_CURRENT_SITE') ?: 1);
    define('BLOG_ID_CURRENT_SITE', env('BLOG_ID_CURRENT_SITE') ?: 1);

    define('SUNRISE', 'on');
}

// ---

define('WP_DEFAULT_THEME', 'wordpress-boilerplate');

define('WP_CONTENT_DIR', __DIR__ . '/app');

// Will be defined in app/sunrise.php for multisite setups
if (!MULTISITE) {
    define('WP_CONTENT_URL', WP_HOME . '/app');
}

// ---

define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

// ---

define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));

// ---

define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);
define('DISALLOW_FILE_MODS', true);
define('DISALLOW_FILE_EDIT', true);

// ---

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/wp/');
}

require_once(ABSPATH . 'wp-settings.php');
