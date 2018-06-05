<?php
/**
 * Plugin Name: Register Theme Directory
 * Plugin URI: https://dotsunited.de
 * Description: Registers /app/themes as custom theme directory.
 * Version: 1.0.0
 * Author: Dots United GmbH
 * Author URI: https://dotsunited.de
 */

/**
 * We need the path of the public/ directory *without* resolving symlinks.
 * WordPress stores the template_root option as absolute path if the theme
 * directory is located outside of the WordPress installation and we need to
 * keep that path stable in cases where directories are symlinked.
 */
if (isset($_SERVER['DOCUMENT_ROOT']) && '' !== trim($_SERVER['DOCUMENT_ROOT'])) {
    // We still need to run the detection logic on $_SERVER['DOCUMENT_ROOT']
    // because wp-cli sets it to the ABSPATH value which points to wp/
    $rootDir = $_SERVER['DOCUMENT_ROOT'];
} elseif (isset($_SERVER['PWD']) && '' !== trim($_SERVER['PWD'])) {
    $rootDir = $_SERVER['PWD'];
} else {
    $rootDir = __DIR__;
}

while (!file_exists($rootDir . '/public')) {
    $rootDir = dirname($rootDir);

    if ('' === $rootDir || '.' === $rootDir) {
        break;
    }
}

$themeDir = str_replace('\\', '/', $rootDir) . '/public/app/themes';

if (!file_exists($themeDir)) {
    return;
}

register_theme_directory($themeDir);

/**
 * Hook to fix theme URLs when the theme directory is located outside of the
 * WordPress installation.
 */
add_filter('theme_root_uri', function ($theme_root_uri) use ($themeDir) {
    if (0 !== strpos($theme_root_uri, $themeDir)) {
        return $theme_root_uri;
    }

    return home_url('/app/themes');
});

unset($rootDir, $themeDir);
