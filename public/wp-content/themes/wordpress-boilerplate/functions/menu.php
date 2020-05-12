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
        while (0 != $prev_root_id) {
            foreach ($menuItems as $menu_item) {
                if ($menu_item->ID == $prev_root_id) {
                    $prev_root_id = $menu_item->menu_item_parent;
                    // don't set the root_id to 0 if we've reached the top of the menu
                    if (0 != $prev_root_id) {
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

class wordpress_boilerplate_mega_menu_walker extends Walker_Nav_Menu
{
	function start_lvl(&$output, $depth = 0, $args = [])
	{
		$indent = str_repeat("\t", $depth);
		if (0 === $depth) {
			$output .= "\n$indent<div class='navigation__sub-menu'>\n";
			$output .= "\n$indent<div class='navigation__sub-menu-bg'>\n";
			$output .= "\n$indent<ul class='sub-menu container'>\n";
		} else {
			$output .= "\n$indent<ul class='sub-menu container'>\n";
		}
	}
}


function wordpress_boilerplate_off_canvas_menu()
{
	return wp_nav_menu([
		'theme_location' => 'main',
		'depth' => 3,
		'fallback_cb' => null,
		'container' => false,
		'walker' => new wordpress_boilerplate_off_canvas_menu_walker(),
		'echo' => false,
	]);
}

class wordpress_boilerplate_off_canvas_menu_walker extends Walker_Nav_Menu
{
	private static $idCounter = 1;
	
	public function start_lvl(&$output, $depth = 0, $args = [])
	{
		parent::start_lvl($output, $depth, $args);
		
		if (0 !== $depth) {
			return;
		}
		
		$parts = explode('<ul', $output);
		
		$last = array_pop($parts);
		
		$id = 'off-canvas-sub-menu-' . self::$idCounter++;
		
		$output = implode('<ul', $parts) . '<button class="js-off-canvas-menu-submenu-control off-canvas-menu__submenu-control" data-ctrly="' . $id . '"><svg class="icon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="#000" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path></svg><span class="visually-hidden">' . _x('Untermenü öffnen', 'button', 'wordpress_boilerplate-kesselreinigung') . '</span></button><ul id="' . $id . '"' . $last;
	}
}

add_filter( 'wp_nav_menu_objects', 'wordpress_boilerplate_submenu_limit', 10, 2 );

function wordpress_boilerplate_submenu_limit( $items, $args ) {
	
	if ( empty( $args->submenu ) ) {
		return $items;
	}
	
	$ids       = wp_filter_object_list( $items, array( 'title' => $args->submenu ), 'and', 'ID' );
	$parent_id = array_pop( $ids );
	$children  = wordpress_boilerplate_submenu_get_children_ids( $parent_id, $items );
	
	foreach ( $items as $key => $item ) {
		
		if ( ! in_array( $item->ID, $children ) ) {
			unset( $items[$key] );
		}
	}
	
	var_dump($children);
	
	return $items;
}

add_filter( 'wp_nav_menu_objects', 'wordpress_boilerplate_submenu_ids', 10, 2 );

function wordpress_boilerplate_submenu_ids( $items, $args ) {
	
	if ( empty( $args->submenu ) ) {
		return $items;
	}
	
	$ids       = wp_filter_object_list( $items, array( 'title' => $args->submenu ), 'and', 'ID' );
	$parent_id = array_pop( $ids );
	$children  = wordpress_boilerplate_submenu_get_children_ids( $parent_id, $items );
	
	return $children;
}


function wordpress_boilerplate_submenu_get_children_ids( $id, $items ) {
	
	$ids = wp_filter_object_list( $items, array( 'menu_item_parent' => $id ), 'and', 'ID' );
	
	foreach ( $ids as $id ) {
		
		$ids = array_merge( $ids, wordpress_boilerplate_submenu_get_children_ids( $id, $items ) );
	}
	
	return $ids;
}

