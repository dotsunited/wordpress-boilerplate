<?php

/**
 * Login Area
 */
add_action( 'login_enqueue_scripts', function() {
	?>
	<style type="text/css">
        #login h1 a, .login h1 a {
            height: 52px;
            margin: 0 auto 25px auto;
            padding: 0;
            width: 228px;

            background-image: url(<?php echo wordpress_boilerplate_asset_url('vendor/images/logo-dotsunited.svg'); ?>);
            background-size: 228px 52px;
            background-repeat: no-repeat;
            background-position: center;
        }
	</style>
	<?php
});

/**
 * Hide auto plugin update note
 */
add_action('admin_head', 'wordpress_boilerplate_hide_auto_update');
function wordpress_boilerplate_hide_auto_update() {
	echo '<style>
    .column-auto-updates {display: none !important;}
  </style>';
}

/**
 * add order column to admin listing screen for header text
 */
// add a column to the post type's admin
// basically registers the column and sets it's title
add_filter('manage_page_posts_columns', function ($columns) {
	$columns['menu_order'] = "Order";
	return $columns;
});

// display the column value
add_action( 'manage_page_posts_custom_column', function ($column_name, $post_id){
	if ($column_name == 'menu_order') {
		echo get_post($post_id)->menu_order;
	}
}, 10, 2);

// make it sortable
$menu_order_sortable_on_screen = 'edit-page';
add_filter('manage_' . $menu_order_sortable_on_screen . '_sortable_columns', function ($columns){
	$columns['menu_order'] = 'menu_order';
	return $columns;
});
