<?php

add_action('ms_loaded', function () {
    if (defined('WP_CONTENT_URL')) {
        die('The constant "WP_CONTENT_URL" is defined (probably in wp-config.php). Please remove or comment out that define() line.');
    }

    if (!defined('WP_CONTENT_DIR')) {
        die('The constant "WP_CONTENT_DIR" is not defined. Please add that define() (probably in wp-config.php).');
    }

    if (isset($GLOBALS['current_blog'])) {
        define('WP_CONTENT_URL', (is_ssl() ? 'https' : 'http') . '://' . $GLOBALS['current_blog']->domain . '/app');
    } else {
        define('WP_CONTENT_URL', WP_HOME . '/app');
    }
});
