<?php
/**
 * Plugin Name: Must-Use Plugin Loader
 * Plugin URI: https://dotsunited.de
 * Description: Loads all Must-Use Plugins from subdirectories in mu-plugins/.
 * Version: 1.0.0
 * Author: Dots United GmbH
 * Author URI: https://dotsunited.de
 */

function mu_plugin_loader_get_plugins()
{
    if (\defined('WP_INSTALLING') && true === WP_INSTALLING) {
        return [];
    }

    if (!\defined('WPMU_PLUGIN_DIR')) {
        return [];
    }

    if (!\function_exists('get_plugin_data')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $dirs = \glob(WPMU_PLUGIN_DIR . '/*', \GLOB_ONLYDIR);

    $transientKey = mu_plugin_loader_transient_key($dirs);

    $plugins = get_site_transient($transientKey);

    if (!empty($plugins)) {
        return $plugins;
    }

    $plugins = [];

    foreach ($dirs as $dir) {
        if ('.' === $dir[0]) {
            continue;
        }

        foreach (\glob($dir . '/*.php') as $file) {
            if (!\is_readable($file)) {
                continue;
            }

            $data = get_plugin_data($file, false, false);

            if (empty($data['Name'])) {
                continue;
            }

            $plugins[plugin_basename($file)] = $file;
        }
    }

    set_site_transient(
        $transientKey,
        $plugins,
        mu_plugin_loader_transient_expiration()
    );

    return $plugins;
}

function mu_plugin_loader_transient_key(array $dirs)
{
    $existingKey = get_site_transient('mu_plugin_loader_transient_key');

    $key = 'mu_plugin_loader_' . md5(implode('', $dirs));

    if ($existingKey !== $key) {
        if ($existingKey) {
            delete_site_transient($existingKey);
        }

        set_site_transient(
            'mu_plugin_loader_transient_key',
            $key,
            mu_plugin_loader_transient_expiration()
        );
    }

    return $key;
}

function mu_plugin_loader_transient_expiration()
{
    return apply_filters(
        'mu_plugin_loader_transient_expiration',
        DAY_IN_SECONDS
    );
}

add_action('muplugins_loaded', function () {
    foreach (mu_plugin_loader_get_plugins() as $path) {
        if (\is_readable($path)) {
            require_once $path;
        }
    }
});

add_action('after_plugin_row_mu-plugin-loader.php', function () {
    $table = new WP_Plugins_List_Table;

    foreach (mu_plugin_loader_get_plugins() as $file => $path) {
        $data = get_plugin_data($path, false);

        $data['Name'] = sprintf(
            '<small style="display:block;opacity:.5">%s</small>↳ %s',
            'Must-Use Plugin Loader',
            $data['Name']
        );

        $table->single_row([$file, $data]);
    }
});
