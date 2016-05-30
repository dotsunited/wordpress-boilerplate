<?php

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
<script><?php echo wordpress_boilerplate_asset_embed('/assets/scripts/main-critical.js'); ?></script>
        <style><?php echo wordpress_boilerplate_asset_embed('/assets/scripts/main-critical.css'); ?></style>
<?php
}, -1000);

add_action('wp_footer', function () {
?>
<link rel="stylesheet" href="<?php echo esc_attr(wordpress_boilerplate_asset('/assets/scripts/main.css')); ?>">
        <script async src="<?php echo esc_attr(wordpress_boilerplate_asset('/assets/scripts/main.js')); ?>"></script>
<?php
}, 1000);

function wordpress_boilerplate_asset($path)
{
    $path = ltrim($path, '/');

    $hash = md5_file(TEMPLATEPATH . '/' . $path);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $uri = substr($path, 0, -strlen($ext)) . $hash . '.' . $ext;

    return get_template_directory_uri() . '/' . $uri;
}

function wordpress_boilerplate_asset_embed($path)
{
    ob_start();
    include TEMPLATEPATH . $path;
    $content = ob_get_clean();

    $targetUrl = rtrim(get_template_directory_uri() . '/' . dirname(ltrim($path, '/')), '/');

    $rewriteUrl = function ($matches) use ($targetUrl) {
        $url = $matches['url'];

        // First check also matches protocol-relative urls like //example.com
        if ((isset($url[0])  && '/' === $url[0]) || false !== strpos($url, '://') || 0 === strpos($url, 'data:')) {
            return $matches[0];
        }

        return str_replace($url, $targetUrl . '/' . $url, $matches[0]);
    };

    $content = preg_replace_callback('/url\((["\']?)(?<url>.*?)(\\1)\)/', $rewriteUrl, $content);
    $content = preg_replace_callback('/@import (?!url\()(\'|"|)(?<url>[^\'"\)\n\r]*)\1;?/', $rewriteUrl, $content);
    // Handle 'src' values (used in e.g. calls to AlphaImageLoader, which is a proprietary IE filter)
    $content = preg_replace_callback('/\bsrc\s*=\s*(["\']?)(?<url>.*?)(\\1)/i', $rewriteUrl, $content);

    return $content;
}
