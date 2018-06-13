<?php

add_filter('wp_default_scripts', function (WP_Scripts $scripts) {
    if (is_admin()) {
        return;
    }

    // Remove embed script (https://core.trac.wordpress.org/changeset/35708)
    $scripts->remove('wp-embed');

    // Remove jquery-migrate by re-registering jquery dependent only on jquery-core
    $scripts->remove('jquery');
    $scripts->add(
        'jquery',
        false,
        array('jquery-core'),
        false
    );
});

$manifest = json_decode(
    file_get_contents(__DIR__.'/../assets/manifest.json'),
    true
);

$head = function() use ($manifest) {
?>
<?php
/*
 * Webfont preloading example
?>
<link rel="preload" href="<?php echo esc_attr(wordpress_boilerplate_asset('assets/scripts/' . $manifest['roboto.woff'])); ?>" as="font" type="font/woff" crossorigin>
*/
?>

<script>window.__assets_public_path__ = <?php echo json_encode(wordpress_boilerplate_asset('assets/')); ?>;</script>
<script><?php echo wordpress_boilerplate_asset_embed('assets/' . $manifest['runtime.js']); ?><?php echo wordpress_boilerplate_asset_embed('assets/' . $manifest['load-css-polyfill.js']); ?></script>
<style data-href="<?php echo esc_attr(wordpress_boilerplate_asset('assets/' . $manifest['main-base.css'])); ?>"><?php echo wordpress_boilerplate_asset_embed('assets/' . $manifest['main-base.css']); ?></style>
<link rel="preload" href="<?php echo esc_attr(wordpress_boilerplate_asset('assets/' . $manifest['main-components.css'])); ?>" as="style" onload="this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="<?php echo esc_attr(wordpress_boilerplate_asset('assets/' . $manifest['main-components.css'])); ?>"></noscript>
<script defer src="<?php echo esc_attr(wordpress_boilerplate_asset('assets/' . $manifest['main-components.js'])); ?>"></script>
<style data-href="<?php echo esc_attr(wordpress_boilerplate_asset('assets/' . $manifest['main-utilities.css'])); ?>"><?php echo wordpress_boilerplate_asset_embed('assets/' . $manifest['main-utilities.css']); ?></style>

<?php
};

add_action('wp_head', $head, -1000);

// Support for the Gravity Forms Iframe Add-on plugin
// https://github.com/cedaro/gravity-forms-iframe
add_action('gfiframe_head', $head, -1000);
add_action('gfiframe_head', function () {
?>
<style>body { background-image: none !important; } .gform_wrapper, .gform_wrapper form { margin: 0 !important; }</style>
<?php
}, -1000);

function wordpress_boilerplate_asset($path)
{
    return rtrim(get_template_directory_uri(), '/') . '/' . ltrim($path, '/');
}

function wordpress_boilerplate_asset_embed($path)
{
    ob_start();
    include TEMPLATEPATH . DIRECTORY_SEPARATOR . $path;
    $content = ob_get_clean();

    $targetUrl = rtrim(get_template_directory_uri(), '/') . '/' . dirname(ltrim($path, '/'));

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

    return trim($content);
}
