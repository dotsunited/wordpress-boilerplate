<?php

add_action('widgets_init', function () {
    register_sidebar([
        'name' => __('Sidebar', 'wordpress-boilerplate'),
        'id' => 'sidebar-1',
        'before_widget' => '<section id="%1$s" class="wysiwyg first:mt-14 overflow-hidden bg-zinc-200 text-grey-darker text-base p-4 widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="font-bold text-base leading-tight mb-2">',
        'after_title' => '</h2>',
    ]);

    register_sidebar([
        'name' => __('Footer', 'wordpress-boilerplate'),
        'id' => 'footer-1',
        'before_widget' => '<div id="%1$s" class="w-full mb-6 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-xl text-white mb-4 font-headlines">',
        'after_title' => '</h3>',
    ]);

    // -- Unregister core widgets ----
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Media_Audio');
    // unregister_widget('WP_Widget_Media_Image');
    unregister_widget('WP_Widget_Media_Gallery');
    unregister_widget('WP_Widget_Media_Video');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    //unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
    //unregister_widget('WP_Nav_Menu_Widget');
    //unregister_widget('WP_Widget_Custom_HTML');

    // -- Unregister plugin widgets ----
    unregister_widget('WP_Widget_PostRatings');
    unregister_widget('GFWidget');
});

add_filter('widget_nav_menu_args', function ($nav_menu_args, $nav_menu, $args) {
    if (0 !== \strpos($args['id'], 'footer-')) {
        return $nav_menu_args;
    }

    return \array_merge((array) $nav_menu_args, [
        'depth' => 1,
        'container' => false,
        'items_wrap' => '<ul id="%1$s" class="list-reset">%3$s</ul>',
        'walker' => new wordpress_boilerplate_widget_menu_walker(),
    ]);
}, 10, 3);

class wordpress_boilerplate_widget_menu_walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) {
        parent::start_el($output, $item, $depth, $args, $id);

        $parts = \explode('class="', $output);

        $last = \array_pop($parts);

        $output = \implode('class="', $parts) . 'class="mb-1 ' . $last;

        $output = \str_replace('<a', '<a class="text-zinc-300"', $output);
    }
}
