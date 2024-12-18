<?php

/**
 * Plugin Name: WordPress Boilerplate
 * Description: The main WordPress Boilerplate plugin.
 * License: MIT
 * Version: 14.2.0
 * Author: Dots United GmbH
 * Author URI: https://dotsunited.de
 */
require_once __DIR__ . '/modules/auto-updates/auto-updates.php';
require_once __DIR__ . '/modules/gutenberg/gutenberg.php';

add_action('plugins_loaded', function () {
    if (0 === \strpos(__DIR__, \str_replace(['/', '\\'], \DIRECTORY_SEPARATOR, WPMU_PLUGIN_DIR))) {
        load_muplugin_textdomain('wordpress-boilerplate', 'wordpress-boilerplate/languages');
    } else {
        load_plugin_textdomain('wordpress-boilerplate', false, 'wordpress-boilerplate/languages');
    }
});
