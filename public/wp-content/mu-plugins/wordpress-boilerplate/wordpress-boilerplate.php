<?php
/**
 * Plugin Name: Wordpress Boilerplate
 * Description: The main Wordpress Boilerplate plugin.
 * License: MIT
 * Version: 12.0.1
 * Author: Dots United GmbH
 * Author URI: https://dotsunited.de
 */
require_once __DIR__ . '/modules/gutenberg/gutenberg.php';

add_action('plugins_loaded', function () {
    if (0 === \strpos(__DIR__, \str_replace(['/', '\\'], \DIRECTORY_SEPARATOR, WPMU_PLUGIN_DIR))) {
        load_muplugin_textdomain('wordpress-boilerplate', 'wordpress-boilerplate/languages');
    } else {
        load_plugin_textdomain('wordpress-boilerplate', false, 'wordpress-boilerplate/languages');
    }
});

function wordpress_boilerplate_is_amp_endpoint()
{
    return \function_exists('is_amp_endpoint') && is_amp_endpoint();
}
