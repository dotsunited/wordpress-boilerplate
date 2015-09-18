<?php

function wordpress_boilerplate_asset($path)
{
    $path = ltrim($path, '/');

    $hash = md5_file(TEMPLATEPATH . '/' . $path);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $uri = substr($path, 0, -strlen($ext)) . $hash . '.' . $ext;

    return get_template_directory_uri() . '/' . $uri;
}

// Remove emoji support
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_filter('wp_default_scripts', function (WP_Scripts $scripts) {
    if (is_admin()) {
        return;
    }

    // Remove jquery-migrate by re-registering jquery dependent only on jquery-core
    $scripts->remove('jquery');
    $scripts->add(
        'jquery',
        false,
        array('jquery-core'),
        false
    );
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'wordpress-boilerplate-ie8',
        wordpress_boilerplate_asset('/assets/scripts/ie8.js'),
        array(),
        null,
        false
    );
    wp_script_add_data('wordpress-boilerplate-ie8', 'conditional', 'lt IE 9');

    wp_enqueue_script(
        'wordpress-boilerplate-main',
        wordpress_boilerplate_asset('/assets/scripts/main.js'),
        array(),
        null,
        true
    );
});

add_action('wp_head', function () {
?>
<script><?php include TEMPLATEPATH . '/assets/scripts/main-critical.js' ?></script>
        <style><?php include TEMPLATEPATH . '/assets/scripts/main-critical.css'; ?></style>
<?php
}, -1000);

add_action('wp_footer', function () {
    $mainCss = wordpress_boilerplate_asset('/assets/scripts/main.css');
?>
<script>
            var el = document.createElement('link');
            el.rel = 'stylesheet';
            el.href = '<?php echo $mainCss; ?>';
            (document.head || document.getElementsByTagName('head')[0]).appendChild(el);
        </script>
        <noscript>
            <link rel="stylesheet" href="<?php echo $mainCss; ?>">
        </noscript>
<?php
}, -1000);
