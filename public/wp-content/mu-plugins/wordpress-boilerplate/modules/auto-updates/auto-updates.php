<?php

/**
* Disable auto updates
 */
add_action('after_setup_theme', function () {
    // Only allow minor updates for core
    add_filter('allow_dev_auto_core_updates', '__return_false');
    add_filter('allow_minor_auto_core_updates', '__return_true');
    add_filter('allow_major_auto_core_updates', '__return_false');

    // Disable auto updates for plugins
    add_filter('auto_update_plugin', '__return_false');

    // Disable auto updates for themes
    add_filter('auto_update_theme', '__return_false');
});

/**
 * Disable auto updates test
 */
add_filter('site_status_tests', function ($tests) {
    unset($tests['direct']['plugin_theme_auto_updates']);

    return $tests;
}, 20);

/**
 * Hide auto update notes & checkbox
 */
add_action('admin_head', 'wordpress_boilerplate_hide_auto_update');
function wordpress_boilerplate_hide_auto_update() {
    echo '<style>
    .column-auto-updates {display: none !important;}
    .theme-info .theme-autoupdate {display: none !important;}
    .metabox-prefs > label:has(#auto-updates-hide) {display: none !important;}
    </style>';
}
