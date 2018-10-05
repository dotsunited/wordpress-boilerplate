<?php

add_action('after_setup_theme', function () {
    load_theme_textdomain('wordpress-boilerplate', TEMPLATEPATH . '/languages');

    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('post-thumbnails');
});

add_action('widgets_init', function () {
    register_nav_menu('main', __('Main Menu', 'wordpress-boilerplate'));

    register_sidebar(array(
        'name' => __('Sidebar', 'wordpress-boilerplate'),
        'id' => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="p-4 mt-8 rounded overflow-hidden bg-grey-lightest text-grey-darker text-base widget %2$s">',
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
    }

?>
    <nav class="pagination">
        <div class="pagination__prev"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'wordpress-boilerplate')); ?></div>
        <div class="pagination__next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'wordpress-boilerplate')); ?></div>
    </nav>
<?php
}
