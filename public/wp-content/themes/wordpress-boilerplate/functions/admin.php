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
