<?php
/**
 * Plugin Name: Register Theme Directory
 * Plugin URI: https://dotsunited.de
 * Description: Registers <code>app/themes/</code> as custom theme directory.
 * Version: 1.0.0
 * Author: Dots United GmbH
 * Author URI: https://dotsunited.de
 */

namespace DotsUnited\RegisterThemeDirectory;

/*
 * Note: WordPress stores absolute paths for the `template_root` and
 * `stylesheet_root` options as well as for the `theme_roots` transient if the
 * theme directory is located outside of the WordPress installation.
 *
 * The path is transformed into a relative path with a %WP_HOME_PATH% prefix
 * before the options are stored and expanded back to an absolute path on
 * reading.
 *
 * This ensures portability for different (symlinked) setups and when the
 * application is moved to a different location.
 */

register_theme_directory(_get_app_theme_path());

add_filter('pre_update_option_template_root', function ($value) {
    if (_get_app_theme_path() === $value) {
        return '%WP_HOME_PATH%/app/themes';
    }

    return $value;
});

add_filter('pre_update_option_stylesheet_root', function ($value) {
    if (_get_app_theme_path() === $value) {
        return '%WP_HOME_PATH%/app/themes';
    }

    return $value;
});

add_filter('option_template_root', function ($value) {
    if (_is_stored_app_theme_path($value)) {
        return _get_app_theme_path();
    }

    return $value;
});

add_filter('option_stylesheet_root', function ($value) {
    if (_is_stored_app_theme_path($value)) {
        return _get_app_theme_path();
    }

    return $value;
});

add_filter('pre_set_site_transient_theme_roots', function ($value) {
    if (!\is_array($value)) {
        return $value;
    }

    $newValue = [];

    foreach ($value as $theme => $path) {
        if (_get_app_theme_path() === $path) {
            $path = '%WP_HOME_PATH%/app/themes';
        }

        $newValue[$theme] = $path;
    }

    return $newValue;
});

add_filter('site_transient_theme_roots', function ($value) {
    if (!\is_array($value)) {
        return $value;
    }

    $newValue = [];

    foreach ($value as $theme => $path) {
        if (_is_stored_app_theme_path($path)) {
            $path = _get_app_theme_path();
        }

        $newValue[$theme] = $path;
    }

    return $newValue;
});

add_filter('theme_root_uri', function ($themeRootUri) {
    if (_get_app_theme_path() === $themeRootUri) {
        return network_home_url('/app/themes');
    }

    return $themeRootUri;
});

function _get_app_theme_path()
{
    static $themePath;

    if (!$themePath) {
        $themePath = _detect_wp_home_path() . '/app/themes';
    }

    return $themePath;
}

function _detect_wp_home_path()
{
    $homePath = __DIR__;

    while (!\is_dir($homePath . '/app/themes')) {
        $homePath = \dirname($homePath);

        if ('' === $homePath || '.' === $homePath) {
            $homePath = '';
            break;
        }
    }

    return $homePath;
}

function _is_stored_app_theme_path($path)
{
    return '/app/themes' === \str_replace('%WP_HOME_PATH%', '', $path);
}
