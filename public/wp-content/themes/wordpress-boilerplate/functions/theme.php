<?php

add_action('after_setup_theme', function () {
    load_theme_textdomain('wordpress-boilerplate', TEMPLATEPATH . '/languages');

    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('post-thumbnails');
	
	// Disable auto plugin update
	add_filter( 'auto_update_plugin', '__return_false' );
});

add_action('widgets_init', function () {
    register_nav_menu('main', __('Main Menu', 'wordpress-boilerplate'));

    register_sidebar(array(
        'name' => __('Sidebar', 'wordpress-boilerplate'),
        'id' => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="p-4 mt-8 rounded overflow-hidden bg-gray-100 text-grey-darker text-base widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="font-bold text-base leading-tight mb-2">',
        'after_title' => '</h2>',
    ));
});

function wordpress_boilerplate_single_post_content($display = true)
{
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

function wordpress_boilerplate_pagination()
{
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

function wordpress_boilerplate_render($slug, array $context = [])
{
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

function wordpress_boilerplate_get_pages($args = '')
{
	if (is_array($args)) {
		$r = &$args;
	} else {
		parse_str($args, $r);
	}
	
	$defaults = array('depth' => 1, 'show_date' => '', 'date_format' => get_option('date_format'),
	                  'child_of' => 0, 'exclude' => '', 'title_li' => __('Pages'), 'echo' => 1, 'authors' => '', 'sort_column' => 'menu_order', );
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

/* Example Usage */

/*
* $args = array(
*	'child_of' => $post->post_parent,
*	'post_type' => 'page',
*	'order' => 'ASC',
*	'orderby' => 'menu_order',
*	'depth' => -1,
* );
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
