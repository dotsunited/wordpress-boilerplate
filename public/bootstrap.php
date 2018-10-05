<?php

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/wp/');
}

// -----------------------------------------------------------------------------

define('WP_SITEURL', WP_HOME . '/wp');
define('WPMU_PLUGIN_DIR', __DIR__ . '/app/mu-plugins');
define('WPMU_PLUGIN_URL', WP_HOME . '/app/mu-plugins');

// -----------------------------------------------------------------------------

define('DISALLOW_FILE_EDIT', true);

// -----------------------------------------------------------------------------

require __DIR__ . '/../vendor/autoload.php';
