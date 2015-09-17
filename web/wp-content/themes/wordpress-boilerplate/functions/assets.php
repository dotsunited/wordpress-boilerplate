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
<script><?php include TEMPLATEPATH . '/assets/scripts/main-critical.js' ?></script>
        <style><?php include TEMPLATEPATH . '/assets/scripts/main-critical.css'; ?></style>
        <!--[if lt IE 9]>
        <script src="<?= esc_attr(wordpress_boilerplate_asset('/assets/scripts/ie8.js')); ?>"></script>
        <![endif]-->
        <script>
        (function(d) {
            var c = function(id) {
                var n = d.getElementById(id), s = d.styleSheets, a;
                for (var i = 0; i < s.length; i++){
                    s[i].href && s[i].href === n.href && (a = 1);
                }
                a ? n.media='all' : setTimeout(function() { c(id); },0);
            };
            var id='main-css',l = d.createElement('link');l.href = <?= json_encode(wordpress_boilerplate_asset('/assets/scripts/main.css')); ?>;l.rel = 'stylesheet';l.media = 'only x';l.id=id;(d.head || d.getElementsByTagName('head')[0]).appendChild(l);c(id);
            var s = d.createElement('script');s.src = <?= json_encode(wordpress_boilerplate_asset('/assets/scripts/main.js')); ?>;s.async = 1;(d.head || d.getElementsByTagName('head')[0]).appendChild(s);
        })(document);
        </script>
        <noscript>
            <link rel="stylesheet" href="<?= esc_attr(wordpress_boilerplate_asset('/assets/scripts/main.css')); ?>">
        </noscript>
<?php
}, -1000);
