<?php

add_action('wp_head', function () {
    /*
     * Webfont preloading example
    ?>

    <link rel="preload" href="<?= esc_attr(wordpress_boilerplate_asset_url_from_manifest('roboto.woff')); ?>" as="font" type="font/woff" crossorigin>

    <?php
    */
}, -1000);

add_action('wp_head', function () {
?>
    <style><?= wordpress_boilerplate_asset_embed_from_manifest('assets/main/index.ts', 'css'); ?></style>
    <script type="module" async src="<?= esc_attr(wordpress_boilerplate_asset_url_from_manifest('assets/main/index.ts')); ?>"></script>
<?php
}, 1000);

function wordpress_boilerplate_asset_url_from_manifest($name, $type = 'file') {
    $manifest = wordpress_boilerplate_asset_manifest();

    if (!isset($manifest[$name])) {
        return null;
    }

    return wordpress_boilerplate_asset_url('assets/' . $manifest[$name][$type]);
}

function wordpress_boilerplate_asset_embed_from_manifest($name, $type = 'file') {
    $manifest = wordpress_boilerplate_asset_manifest();

    if (!isset($manifest[$name])) {
        return null;
    }

    if (is_array($manifest[$name][$type])) {
        return wordpress_boilerplate_asset_embed('assets/' . $manifest[$name][$type][0]);
    }

    return wordpress_boilerplate_asset_embed('assets/' . $manifest[$name][$type]);
}

function wordpress_boilerplate_asset_manifest() {
    static $manifest;

    if (!$manifest) {
        $manifest = json_decode(
            file_get_contents(__DIR__ . '/../assets/.vite/manifest.json'),
            true
        );
    }

    return $manifest;
}

function wordpress_boilerplate_asset_url($path) {
    return rtrim(get_template_directory_uri(), '/') . '/' . ltrim($path, '/');
}

function wordpress_boilerplate_asset_embed($path, $attributes = []) {
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

    // Add attributes to the <svg> tag
    if (preg_match('/<svg[^>]*>/', $content, $matches)) {
        $svgTag = $matches[0];

        $attributesString = '';

        foreach ($attributes as $name => $value) {
            $attributesString .= ' ' . $name . '="' . esc_attr($value) . '"';
        }

        $content = str_replace($svgTag, rtrim($svgTag, '>') . $attributesString . '>', $content);
    }

    return trim($content);
}

function _wordpress_boilerplate_asset_normalize_path($path) {
    $themeUri = get_template_directory_uri();
    $uriPath = parse_url($themeUri, \PHP_URL_PATH);

    if (0 === \strpos($path, $uriPath)) {
        $path = \substr($path, \strlen($uriPath));
    }

    return $path;
}
