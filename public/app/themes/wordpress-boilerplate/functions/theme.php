<?php

// Remove <meta name="generator" content="WordPress x.x.x" />
remove_action('wp_head', 'wp_generator');

add_action('after_setup_theme', function () {
    load_theme_textdomain('wordpress-boilerplate', TEMPLATEPATH . '/languages');

    remove_theme_support('automatic-feed-links');

    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('post-thumbnails');
});

add_action('widgets_init', function () {
    register_nav_menu('main', __('Main Menu', 'wordpress-boilerplate'));

    register_sidebar(array(
        'name' => __('Sidebar', 'wordpress-boilerplate'),
        'id' => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget__title">',
        'after_title' => '</h2>',
    ));
});

function wordpress_boilerplate_pagination()
{
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return;
    }

?>
    <nav class="pagination" role="navigation">
        <div
            class="pagination__prev"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'wordpress-boilerplate')); ?></div>
        <div
            class="pagination__next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'wordpress-boilerplate')); ?></div>
    </nav>
<?php
}
