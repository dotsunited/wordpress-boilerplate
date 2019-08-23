<?php
/**
 * Plugin Name: Dots United Responsify
 * Plugin URI: https://github.com/dotsunited/wordpress-plugin-responsify
 * Description: Automagically responsify HTML elements like <code>iframe</code>'s and <code>table</code>'s.
 * License: MIT
 * Author: Dots United GmbH
 * Version: 1.0.0
 * Author: Dots United GmbH
 * Author URI: https://dotsunited.de
 */

namespace DotsUnited\Responsify;

add_filter('the_content', function ($content) {
    $content = iframes($content);
    $content = tables($content);

    return $content;
});

function iframes($html)
{
    // Remove <p>'s around <iframes>'s
    $html = \preg_replace_callback('/<p><iframe([^<]+)<\/iframe><\/p>/isU', function ($matches) {
        return '<iframe' . $matches[1] . '</iframe>';
    }, $html);

    $html = \preg_replace_callback('/<iframe(.+)><\/iframe>/isU', function ($matches) {
        $width = null;
        $height = null;
        $style = '';

        if (\preg_match('/width="([^"]+)"/iU', $matches[1], $wMatch)) {
            $width = $wMatch[1];
        }

        if (\preg_match('/height="([^"]+)"/iU', $matches[1], $hMatch)) {
            $height = $hMatch[1];
        }

        if (\preg_match('/style="([^"]+)"/iU', $matches[1], $hMatch)) {
            $style = \trim($hMatch[1], ';') . ';';
        }

        $paddingBottom = '56.25';

        if ($width && $height) {
            $calcWidth = $width;
            $calcHeight = $height;

            // Normalize if both are percentage values
            if ('%' === \substr($calcWidth, -1) && '%' === \substr($calcHeight, -1)) {
                $calcWidth = \substr($calcWidth, 0, -1);
                $calcHeight = \substr($calcHeight, 0, -1);
            }

            if (\is_numeric($calcWidth) && \is_numeric($calcHeight)) {
                $paddingBottom = \sprintf('%.2F', ($calcHeight / $calcWidth) * 100);
            }
        }

        $iFrameAttr = \preg_replace('/style="([^"]+)"/iU', '', $matches[1]);
        $iFrameAttr .= '  style="' . $style . 'position:absolute;top:0;left:0;width:100%;height:100%;"';

        $styleAttr = '';

        if ($width) {
            if (\is_numeric($width)) {
                $styleAttr = ' style="max-width:' . $width . 'px"';
            } elseif ('%' === \substr($width, -1)) {
                $styleAttr = ' style="max-width:' . $width . '"';
            }
        }

        return '<div class="responsify-iframe"' . $styleAttr . '><div style="position:relative;padding-bottom:' . $paddingBottom . '%;height:0;overflow:hidden;width:100%;"><iframe' . $iFrameAttr . '></iframe></div></div>';
    }, $html);

    return $html;
}

function tables($html)
{
    $html = \preg_replace_callback('/<table(.*)>(.+)<\/table>/isU', function ($matches) {
        $width = null;
        $style = '';

        if (\preg_match('/width="([^"]+)"/iU', $matches[1], $wMatch)) {
            $width = $wMatch[1];
        }

        if (\preg_match('/style="([^"]+)"/iU', $matches[1], $hMatch)) {
            $style = \trim($hMatch[1], ';') . ';';
        }

        $tableAttr = \preg_replace('/style="([^"]+)"/iU', '', $matches[1]);
        $tableAttr .= '  style="' . $style . 'min-width:100%;"';

        $styleAttr = '';

        if ($width) {
            if (\is_numeric($width)) {
                $styleAttr = ' style="max-width:' . $width . 'px"';
            } elseif ('%' === \substr($width, -1)) {
                $styleAttr = ' style="max-width:' . $width . '"';
            }
        }

        return '<div class="responsify-table"' . $styleAttr . '><div style="display:block;overflow-x:auto;width:100%;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar"><table' . $tableAttr . '>' . $matches[2] . '</table></div></div>';
    }, $html);

    return $html;
}
