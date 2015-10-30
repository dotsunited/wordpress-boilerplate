<?php
/*
Plugin Name: Dots United WordPress Editor Grid Plugin
Plugin URI: https://github.com/dotsunited/wordpress-plugin-editor-grid
Description: Editor extension to create and manage grids.
License: MIT
Author: Dots United GmbH
Version: 1.0.0
Author URI: https://dotsunited.de
*/

$baseUrl = trailingslashit(plugin_dir_url(__FILE__));

add_filter('mce_external_plugins', function ($plugins) use ($baseUrl) {
    global $tinymce_version;

    /* WP 3.8 with tinyMCE 3 */
    if (version_compare($tinymce_version, '400', '<')) {
        // We only support tinyMCE 4
        return $plugins;
    }

    /* WP 3.9 with tinyMCE 4 */
    $plugins['grid'] = $baseUrl . 'assets/editor.js?ver=' . urlencode(md5_file(__DIR__ . '/assets/editor.js'));

    return $plugins;
});

add_filter('mce_buttons_3', function ($buttons, $editor_id) {
    $editor_ids = apply_filters('grid_editor_ids', array('content'));

    if (!is_array($editor_ids)) {
        return $buttons;
    }

    if (!in_array($editor_id, $editor_ids)) {
        return $buttons;
    }

    array_push(
        $buttons,
        'grid_create'
    );

    return $buttons;
}, 1, 2);

add_filter('mce_css', function ($mce_css) use ($baseUrl) {
    $file = apply_filters(
        'grid_editor_css',
        $baseUrl . 'assets/editor.css?ver=' . urlencode(md5_file(__DIR__ . '/assets/editor.css'))
    );

    if ($file) {
        $mce_css .= ', ' . $file;
    }

    return $mce_css;
});

add_action('admin_enqueue_scripts', function () use ($baseUrl) {
    wp_enqueue_script('jquery');

    wp_enqueue_style(
        'grid_buttons',
        $baseUrl . 'assets/buttons.css',
        array(),
        md5_file(__DIR__ . '/assets/buttons.css')
    );
});
