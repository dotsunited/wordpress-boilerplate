<?php

// Remove emoji support
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_action('init', function () {
    // Same check as in wp_deregister_script()
    $current_filter = current_filter();
    if ((is_admin() && 'admin_enqueue_scripts' !== $current_filter) ||
        ('wp-login.php' === $GLOBALS['pagenow'] && 'login_enqueue_scripts' !== $current_filter)
    ) {
        return;
    }

    // Since our main.js includes jQuery, we register it under the jquery handle.
    // Note, that it does not contain jquery-migrate! If our theme or a plugin
    // requires it, it has to be added manually.
    wp_deregister_script('jquery');
    wp_register_script(
        'jquery',
        get_template_directory_uri() . '/assets/scripts/main.' . md5_file(__DIR__ . '/../assets/scripts/main.js') . '.js',
        array(),
        null,
        false // Load in head since we add the async attribute with the script_loader_tag filter
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

    // This is now our main.js
    wp_enqueue_script('jquery');
});

add_filter('script_loader_tag', function($tag, $handle) {
    if ('jquery' === $handle) {
        $tag = str_replace('<script', '<script async', $tag);
    }

    return $tag;
}, 10, 2);

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
