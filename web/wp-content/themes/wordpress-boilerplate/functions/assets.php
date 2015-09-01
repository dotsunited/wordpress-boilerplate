<?php

// Remove emoji support
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_filter('wp_default_scripts', function (WP_Scripts $scripts) {
    if (is_admin()) {
        return;
    }

    // Re-register jquery-core with proper cache busting
    $scripts->remove('jquery-core');
    $scripts->add(
        'jquery-core',
        '/wp-includes/js/jquery/jquery.' . md5_file(ABSPATH . '/wp-includes/js/jquery/jquery.js') . '.js',
        array(),
        null
    );

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
        get_template_directory_uri() . '/assets/scripts/ie8.' . md5_file(__DIR__ . '/../assets/scripts/ie8.js') . '.js',
        array(),
        null,
        false
    );
    wp_script_add_data('wordpress-boilerplate-ie8', 'conditional', 'lt IE 9');

    wp_enqueue_script(
        'wordpress-boilerplate-main',
        get_template_directory_uri() . '/assets/scripts/main.' . md5_file(__DIR__ . '/../assets/scripts/main.js') . '.js',
        array(),
        null,
        true
    );
});

add_action('wp_head', function () {
?>
<script><?php include __DIR__ . '/../assets/scripts/main-critical.js' ?></script>
        <style><?php include __DIR__ . '/../assets/scripts/main-critical.css'; ?></style>
<?php
}, -1000);

add_action('wp_footer', function () {
    $mainCss = get_template_directory_uri() . '/assets/scripts/main.' . md5_file(__DIR__ . '/../assets/scripts/main.css') . '.css';
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
