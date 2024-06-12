<?php

add_action('after_setup_theme', function () {
    load_theme_textdomain('wordpress-boilerplate', TEMPLATEPATH . '/languages');

    add_theme_support('title-tag');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('post-thumbnails');

    // Disable auto updates
    add_filter('auto_update_plugin', '__return_false');
    add_filter('auto_update_theme', '__return_false');

    // Disable theme editor
    define('DISALLOW_FILE_EDIT', true);
});

// Disable auto updates test
add_filter('site_status_tests', function ($tests) {
    unset($tests['direct']['plugin_theme_auto_updates']);

    return $tests;
}, 20);

function wordpress_boilerplate_single_post_content($display = true) {
    $post = get_queried_object();

    if (empty($post->post_content)) {
        return null;
    }

    $content = $post->post_content;

    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);

    if (!$display) {
        return $content;
    }

    echo $content;
}

function wordpress_boilerplate_pagination() {
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return;
    } ?>
    <nav class="pagination">
        <div class="pagination__prev"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'wordpress-boilerplate')); ?></div>
        <div class="pagination__next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'wordpress-boilerplate')); ?></div>
    </nav>
<?php
}

function wordpress_boilerplate_render($slug, array $context = []) {
    $template = locate_template("$slug.php", false, false);

    if (!$template) {
        return null;
    }

    $render = static function () {
        \extract(\func_get_arg(1), \EXTR_OVERWRITE);

        \ob_start();

        require \func_get_arg(0);

        return \ob_get_clean();
    };

    return \trim($render($template, $context));
}

function wordpress_boilerplate_get_pages($args = '') {
    if (is_array($args)) {
        $r = &$args;
    } else {
        parse_str($args, $r);
    }

    $defaults = [
        'depth'       => 1,
        'show_date'   => '',
        'date_format' => get_option('date_format'),
        'child_of'    => 0,
        'exclude'     => '',
        'title_li'    => __('Pages'),
        'echo'        => 1,
        'authors'     => '',
        'sort_column' => 'menu_order'
    ];
    $r = array_merge($defaults, $r);

    $output = '';
    $current_page = 0;

    // sanitize, mostly to keep spaces out
    $r['exclude'] = preg_replace('[^0-9,]', '', $r['exclude']);

    // Allow plugins to filter an array of excluded pages
    $r['exclude'] = implode(',', apply_filters('wp_list_pages_excludes', explode(',', $r['exclude'])));

    // Query pages.
    $pages = get_pages($r);

    return $pages;
}

// add PhotoSwipe data attributes to gallery images
add_filter('render_block', function ($block_content, $block) {
    if ('core/gallery' === $block['blockName']) {
        $dom = new DOMDocument();
        $dom->loadHTML($block_content);
        $images = $dom->getElementsByTagName('a');

        foreach ($images as $image) {
            if (strpos($image->getAttribute('href'), 'wp-content') === false) {
                return $block_content;
            }

            $img = $image->getElementsByTagName('img')->item(0);
            $full_size_path = get_attached_file($img->getAttribute('data-id'));
            $size = getimagesize($full_size_path);

            $image->setAttribute('data-pswp-width', $size[0]);
            $image->setAttribute('data-pswp-height', $size[1]);
            $image->setAttribute('data-cropped', 'true');

            // add button to open image in lightbox
            $button = $dom->createElement('button');
            $button->setAttribute('class', 'lightbox-trigger');
            $button->setAttribute('type', 'button');
            $button->setAttribute('aria-haspopup', 'dialog');
            $button->setAttribute('aria-label', esc_attr(_('Enlarge image')));

            $svg = $dom->createElement('svg');
            $svg->setAttribute('xmlns', 'http://www.w3.org/2000/svg');
            $svg->setAttribute('width', '12');
            $svg->setAttribute('height', '12');
            $svg->setAttribute('fill', 'none');
            $svg->setAttribute('viewBox', '0 0 12 12');

            $path = $dom->createElement('path');
            $path->setAttribute('fill', '#fff');
            $path->setAttribute('d', 'M2 0a2 2 0 0 0-2 2v2h1.5V2a.5.5 0 0 1 .5-.5h2V0H2Zm2 10.5H2a.5.5 0 0 1-.5-.5V8H0v2a2 2 0 0 0 2 2h2v-1.5ZM8 12v-1.5h2a.5.5 0 0 0 .5-.5V8H12v2a2 2 0 0 1-2 2H8Zm2-12a2 2 0 0 1 2 2v2h-1.5V2a.5.5 0 0 0-.5-.5H8V0h2Z');

            $svg->appendChild($path);
            $button->appendChild($svg);

            $image->insertBefore($button, $image->nextSibling);
            $image->parentNode->setAttribute('class', $image->parentNode->getAttribute('class') . ' wp-lightbox-container');
        }

        $block_content = $dom->saveHTML();
    }

    return $block_content;
}, 10, 2);

/* Example Usage */

/*
* $args = [
*   'child_of' => $post->post_parent,
*   'post_type' => 'page',
*   'order' => 'ASC',
*   'orderby' => 'menu_order',
*   'depth' => -1,
* ];
* $page = wordpress_boilerplate_get_pages($args);
*/

/*
* Register template redirect action callback
*
add_action('template_redirect', 'wordpress_boilerplate_remove_wp_archives');

// Remove archives
function wordpress_boilerplate_remove_wp_archives(){
    //If we are on category or tag or date or author archive
    if( is_category() || is_tag() || is_date() || is_author() ) {
        global $wp_query;
        $wp_query->set_404(); //set to 404 not found page
    }
}

/**
* Redirect attachment pages to 404
*
add_action( 'template_redirect', 'canada_attachment_redirect', 10 );
function canada_attachment_redirect() {
    if( is_attachment() ) {
        // $url = wp_get_attachment_url( get_queried_object_id() );
        // wp_redirect( $url, 301 );
        global $wp_query;
        $wp_query->set_404(); //set to 404 not found page
    }
    return;
}
*/
