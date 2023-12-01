<div class="container py-4 hidden md:flex flex-row flex-wrap items-center justify-between">
	<a href="<?= esc_attr(get_home_url()); ?>" class="logo-large items-center flex-shrink-0 text-white mr-6" title="<?= _x('Click here to go back to frontpage', 'logo', 'wordpress-boilerplate'); ?>">
		<span class="screen-reader-text"><?= _x('Click here to go back to frontpage', 'logo', 'wordpress-boilerplate'); ?></span>
		<?= wordpress_boilerplate_asset_embed('/vendor/images/logo-dotsunited.svg', 'w-48'); ?>
	</a>
	
	<nav class="navigation navigation--desktop">
		<?php wp_nav_menu(array(
			'theme_location' => 'main',
			'depth' => 1,
			'fallback_cb' => null,
			'container' => false,
			'items_wrap' => '<ul id="%1$s" class="list-none flex flex-grow %2$s">%3$s</ul>',
			'walker' => new wordpress_boilerplate_mega_menu_walker()
		)); ?>
	</nav>
</div>
