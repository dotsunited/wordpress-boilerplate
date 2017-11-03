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

$head = function() {
$manifest = json_decode(file_get_contents(wordpress_boilerplate_asset('/assets/scripts/manifest.json')), true);
?>
    <script>window.__assets_public_path__ = <?php echo json_encode(get_template_directory_uri() . '/assets/scripts/'); ?></script>
	
	<?php /* Load preload assets */ ?>
    <link rel="preload"
          href="<?php echo esc_attr(wordpress_boilerplate_asset('/assets/scripts/' . $manifest['static/roboto-2fc9bb16fbfee39e2559e5cbf5f90b225e0a8b92.woff'])); ?>"
          as="font" type="font/woff" crossorigin="anonymous">
    <link rel="preload"
          href="<?php echo esc_attr(wordpress_boilerplate_asset('/assets/scripts/' . $manifest['static/roboto-7a4ddb6733c33dfe9ec94c82a5e7f5da885f5182.woff'])); ?>"
          as="font" type="font/woff" crossorigin="anonymous">
    <?php /* Load preload assets */ ?>
    <style><?php echo wordpress_boilerplate_asset_embed('/assets/scripts/'. $manifest['main-critical.css']); ?></style>
    <script><?php echo wordpress_boilerplate_asset_embed('/assets/scripts/'. $manifest['main-critical.js']); ?></script>
    <link rel="preload" type="text/css" href="<?php echo esc_attr(wordpress_boilerplate_asset('/assets/scripts/' .  $manifest['main.css'])); ?>" as="style"
          onload="this.rel='stylesheet'">
    <script async defer src="<?php echo esc_attr(wordpress_boilerplate_asset('/assets/scripts/' . $manifest['main.js'])); ?>"></script>
<?php
};

add_action('wp_head', $head, -1000);

// Support for the Gravity Forms Iframe Add-on plugin
// https://github.com/cedaro/gravity-forms-iframe
add_action('gfiframe_head', $head, -1000);
add_action('gfiframe_head', function () {
?>
<style>body { background-image: none !important; }  .gform_wrapper, .gform_wrapper form {  margin: 0 !important; }</style>
<?php
}, -1000);

function wordpress_boilerplate_asset($path)
{
    $path = ltrim($path, '/');

    $hash = md5_file(TEMPLATEPATH );
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $uri = substr($path, 0, -strlen($ext)) . $ext;

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
