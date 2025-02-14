<?php

/**
 * Plugin Name: WordPress Boilerplate
 * Description: The main WordPress Boilerplate plugin.
 * License: MIT
 * Version: 15.0.1
 * Author: Dots United GmbH
 * Author URI: https://dotsunited.de
 */
require_once __DIR__ . '/modules/auto-updates/auto-updates.php';
require_once __DIR__ . '/modules/gutenberg/gutenberg.php';

function load_textdomain_notice($domain, $name, $type) {
    // skip if locale is 'en_US', because the theme is in English by default
    if (get_locale() === 'en_US') {
        return;
    }

    add_action('admin_notices', function () use ($domain, $name, $type) {
        echo '<div class="error"><p>' . sprintf(__("The $type \"%s\" could not find any language files.", $domain), $name) . '</p></div>';
    });

    error_log("$name: No language files found");
}

add_action('plugins_loaded', function () {
    if (0 === \strpos(__DIR__, \str_replace(['/', '\\'], \DIRECTORY_SEPARATOR, WPMU_PLUGIN_DIR))) {
        if (!load_muplugin_textdomain('wordpress-boilerplate', 'wordpress-boilerplate/languages')) {
            load_textdomain_notice('wordpress-boilerplate', 'wordpress-boilerplate', 'mu-plugin');
        }
    } else {
        if (!load_plugin_textdomain('wordpress-boilerplate', false, 'wordpress-boilerplate/languages')) {
            load_textdomain_notice('wordpress-boilerplate', 'wordpress-boilerplate', 'plugin');
        }
    }
});
