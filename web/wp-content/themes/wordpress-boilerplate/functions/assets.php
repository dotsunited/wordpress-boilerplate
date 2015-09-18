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

add_action('wp_head', function () {
?>
<!--[if lt IE 9]>
        <script src="<?php echo esc_attr(wordpress_boilerplate_asset('/assets/scripts/ie8.js')); ?>"></script>
        <![endif]-->
        <script><?php include TEMPLATEPATH . '/assets/scripts/main-critical.js' ?></script>
        <style><?php include TEMPLATEPATH . '/assets/scripts/main-critical.css'; ?></style>
<?php
}, -1000);

add_action('wp_footer', function () {
?>
<link rel="stylesheet" href="<?php echo esc_attr(wordpress_boilerplate_asset('/assets/scripts/main.css')); ?>">
        <script async src="<?php echo esc_attr(wordpress_boilerplate_asset('/assets/scripts/main.js')); ?>"></script>
<?php
}, -1000);
