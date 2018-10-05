<?php

// That path must be adjusted for symlink based deployment setups,
// eg. to /path/to/current/public
define('ROOT_PATH', __DIR__);

// -----------------------------------------------------------------------------

define('WP_HOME', 'http://wordpress-boilerplate.localhost');

// -----------------------------------------------------------------------------

define('DB_NAME', 'wordpress-boilerplate');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
$table_prefix = 'wp_';

// -----------------------------------------------------------------------------

// Generate at https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY', '');
define('SECURE_AUTH_KEY', '');
define('LOGGED_IN_KEY', '');
define('NONCE_KEY', '');
define('AUTH_SALT', '');
define('SECURE_AUTH_SALT', '');
define('LOGGED_IN_SALT', '');
define('NONCE_SALT', '');

// -----------------------------------------------------------------------------

// define('WP_ALLOW_MULTISITE', false);
// define('MULTISITE', false);
// define('SUBDOMAIN_INSTALL', false);
// define('DOMAIN_CURRENT_SITE', str_replace(['https://', 'http://'], '', WP_HOME));
// define('PATH_CURRENT_SITE', '/');
// define('SITE_ID_CURRENT_SITE', 1);
// define('BLOG_ID_CURRENT_SITE', 1);

// define('WP_DEFAULT_THEME', 'wordpress-boilerplate');

// -----------------------------------------------------------------------------

define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', true);
define('WP_DEBUG_LOG', false);

// -----------------------------------------------------------------------------

require ROOT_PATH . '/bootstrap.php';

require_once ABSPATH . 'wp-settings.php';
