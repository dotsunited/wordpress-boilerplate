<?php

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

function wordpress_boilerplate_find_menu_root($location, $selector, $directParent = false)
{
    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations[$location]);
    $menuItems = wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC', 'update_post_term_cache' => false));

    _wp_menu_item_classes_by_context($menuItems);

    $sorted_menu_items = array();
    foreach ((array)$menuItems as $menuItem) {
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
