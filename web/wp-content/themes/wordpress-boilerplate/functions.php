<?php

// Actions

add_action('wp_enqueue_scripts', function () {
    //wp_enqueue_style('wordpress-boilerplate-webfont', '//fonts.googleapis.com/css?family=Droid+Sans:400,700');
    wp_enqueue_style('wordpress-boilerplate-style', get_stylesheet_uri(), array(), md5_file(__DIR__ . '/style.css'));

    wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr-2.7.0.min.js', array(), null, false);
    //wp_enqueue_script('wordpress-boilerplate-libs', get_template_directory_uri() . '/assets/js/libs.js', array('jquery'), md5_file(dirname(__FILE__) . '/assets/js/libs.js'), true);
    wp_enqueue_script('wordpress-boilerplate-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), md5_file(dirname(__FILE__) . '/assets/js/script.js'), true);
});

add_action('after_setup_theme', function () {
    load_theme_textdomain('wordpress-boilerplate', __DIR__ . '/languages');

    // Switches default core markup for search form, comment form, and comments
    // to output valid HTML5.
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list'));

    remove_theme_support('automatic-feed-links');

    add_theme_support('post-thumbnails');
});

add_action('widgets_init', function () {
    register_nav_menu('main', __('Main Menu', 'wordpress-boilerplate'));

    register_sidebar( array(
        'name'          => __('Sidebar', 'wordpress-boilerplate'),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
});

// Filter

add_filter('wp_title', function ($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    if (is_front_page()) {
        // Add the site name.
        $title .= " $sep " . get_bloginfo('title', 'display');
    }

    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', 'wordpress-boilerplate'), max($paged, $page));
    }

    return $title;
}, 100, 2);

// From: http://christianvarga.com/2012/12/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
add_filter('wp_nav_menu_objects', function ($sorted_menu_items, $args) {
    if (!isset($args->wordpress_boilerplate_submenu)) {
        return $sorted_menu_items;
    }

    if (!isset($args->wordpress_boilerplate_root)) {
        $root_id = 0;
        $root = wordpress_boilerplate_find_menu_root_from_items($sorted_menu_items, function ($menuItem) {
            return $menuItem->current;
        });
        if ($root) {
            $root_id = $root->ID;
        }
    } else {
        $root_id = $args->wordpress_boilerplate_root;
    }

    $menu_item_parents = array();
    foreach ($sorted_menu_items as $key => $item) {
        // init menu_item_parents
        if ($item->ID == $root_id) {
            $menu_item_parents[] = $item->ID;
        }

        if (in_array($item->menu_item_parent, $menu_item_parents)) {
            // part of sub-tree: keep!
            $menu_item_parents[] = $item->ID;
        } else {
            // not part of sub-tree: away with it!
            unset($sorted_menu_items[$key]);
        }
    }

    return $sorted_menu_items;
}, 10, 2);

// Functions

function wordpress_boilerplate_pagination()
{
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return;
    }

?>
<nav class="pagination" role="navigation">
    <div class="pagination__prev"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'wordpress-boilerplate')); ?></div>
    <div class="pagination__next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'wordpress-boilerplate')); ?></div>
</nav>
<?php
}

// Helper

function wordpress_boilerplate_find_menu_root($location, $selector, $directParent = false)
{
    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations[$location]);
    $menuItems = wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC', 'update_post_term_cache' => false));

    _wp_menu_item_classes_by_context($menuItems);

    $sorted_menu_items = array();
    foreach ((array) $menuItems as $menuItem) {
        $sorted_menu_items[$menuItem->menu_order] = $menuItem;
    }
    unset($menuItems);

    $sorted_menu_items = apply_filters('wp_nav_menu_objects', $sorted_menu_items, null);

    return wordpress_boilerplate_find_menu_root_from_items($sorted_menu_items, $selector, $directParent);
}

function wordpress_boilerplate_find_menu_root_from_items($menuItems, $selector, $directParent = false)
{
    $root_id = 0;
    // find the current menu item
    foreach ($menuItems as $menu_item) {
        if ($selector($menu_item)) {
            // set the root id based on whether the current menu item has a parent or not
            $root_id = ($menu_item->menu_item_parent) ? $menu_item->menu_item_parent : $menu_item->ID;
            break;
        }
    }

    if (!$directParent) {
        $prev_root_id = $root_id;
        while ($prev_root_id != 0) {
            foreach ($menuItems as $menu_item) {
                if ($menu_item->ID == $prev_root_id) {
                    $prev_root_id = $menu_item->menu_item_parent;
                    // don't set the root_id to 0 if we've reached the top of the menu
                    if ($prev_root_id != 0) {
                        $root_id = $menu_item->menu_item_parent;
                    }
                    break;
                }
            }
        }
    }

    foreach ($menuItems as $item) {
        if ($item->ID == $root_id) {
            return $item;
        }
    }

    return null;
}
