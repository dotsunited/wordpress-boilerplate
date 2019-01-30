<?php

add_action('wp_head', function () {
    /*
     * Webfont preloading example
    ?>

    <link rel="preload" href="<?php echo esc_attr(wordpress_boilerplate_asset_url_from_manifest('roboto.woff')); ?>" as="font" type="font/woff" crossorigin>

    <?php
    */
}, -1000);

add_action('wp_head', function () {
    ?>

    <script>window.__assets_public_path__ = <?php echo json_encode(wordpress_boilerplate_asset_url('assets/')); ?>;</script>
    <script><?php echo wordpress_boilerplate_asset_embed_from_manifest('runtime.js'); ?></script>
    <style><?php echo wordpress_boilerplate_asset_embed_from_manifest('main.css'); ?></style>
    <script async src="<?php echo esc_attr(wordpress_boilerplate_asset_url_from_manifest('main.js')); ?>"></script>

    <?php
}, 1000);

add_action('wp_footer', function () {
    echo wordpress_boilerplate_asset_embed_from_manifest('img/symbol-defs.svg');
}, 1000);

function wordpress_boilerplate_asset_svg_icon($name, array $args = [])
{
    $args = wp_parse_args($args, [
        'class' => '',
        'aria-hidden' => 'true',
        'role' => 'img',
    ]);

    $class = 'icon icon-' . $name;

    if (!empty($args['class'])) {
        $class .= ' ' . trim($args['class']);
    }

    /*
     * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
     * See https://core.trac.wordpress.org/ticket/38387.
     */
    return '<svg class="' . esc_attr($class) . '" aria-hidden="' . esc_attr($args['aria-hidden']) . '" role="' . esc_attr($args['role']) . '"> <use href="#icon-' . esc_html($name) . '" xlink:href="#icon-' . esc_html($name) . '"></use> </svg>';
}

function wordpress_boilerplate_asset_url_from_manifest($name)
{
    $manifest = wordpress_boilerplate_asset_manifest();

    if (!isset($manifest[$name])) {
        return null;
    }

    return wordpress_boilerplate_asset_url('assets/' . $manifest[$name]);
}

function wordpress_boilerplate_asset_embed_from_manifest($name)
{
    $manifest = wordpress_boilerplate_asset_manifest();

    if (!isset($manifest[$name])) {
        return null;
    }

    return wordpress_boilerplate_asset_embed('assets/' . $manifest[$name]);
}

function wordpress_boilerplate_asset_manifest()
{
    static $manifest;

    if (!$manifest) {
        $manifest = json_decode(
            file_get_contents(__DIR__ . '/../assets/manifest.json'),
            true
        );
    }

    return $manifest;
}

function wordpress_boilerplate_asset_url($path)
{
    return rtrim(get_template_directory_uri(), '/') . '/' . ltrim($path, '/');
}

function wordpress_boilerplate_asset_embed($path)
{
    $path = _wordpress_boilerplate_asset_normalize_path($path);

    $content = file_get_contents(TEMPLATEPATH . DIRECTORY_SEPARATOR . $path);

    $targetUrl = rtrim(get_template_directory_uri(), '/') . '/' . dirname(ltrim($path, '/'));

    $rewriteUrl = function ($matches) use ($targetUrl) {
        $url = $matches['url'];

        if (!isset($url[0])) {
            return $matches[0];
        }

        if (
            // Also matches protocol-relative urls like //example.com
            0 === strpos($url, '/') ||
            // Matches anchors, like clip-path:url(#id) in SVGs
            0 === strpos($url, '#') ||
            false !== strpos($url, '://') ||
            0 === strpos($url, 'data:')
        ) {
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

function _wordpress_boilerplate_asset_normalize_path($path)
{
    $themeUri = get_template_directory_uri();
    $uriPath = parse_url($themeUri, \PHP_URL_PATH);

    if (0 === \strpos($path, $uriPath)) {
        $path = \substr($path, \strlen($uriPath));
    }

    return $path;
}
