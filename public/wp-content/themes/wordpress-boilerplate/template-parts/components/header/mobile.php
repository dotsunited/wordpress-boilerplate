<div class="flex md:hidden flex-row flex-wrap items-center justify-between p-2 z-20 relative">
	<a href="<?php echo esc_attr(get_home_url()); ?>" title="Back to frontpage">
		<span class="screen-reader-text"><?php echo _x('Click here to go back to frontpage', 'logo', 'wordpress-boilerplate'); ?></span>
		<?php echo wordpress_boilerplate_asset_embed('/vendor/images/logo-dotsunited.svg'); ?>
	</a>
	
	<div class="off-canvas-menu">
		<div class="">
			<button data-ctrly="off-canvas-menu-target" class="js-off-canvas-menu-control off-canvas-menu__control" title="<?php echo _x('Open navigation', 'button', 'wordpress-boilerplate'); ?>">
				<span class="off-canvas-menu__control-icon" aria-hidden="true"><span></span></span>
				<span class="visually-hidden"><?php echo _x('Open navigation', 'button', 'wordpress-boilerplate'); ?></span>
			</button>
		</div>
		
		<section class="off-canvas-menu__target" id="off-canvas-menu-target">
			<div class="relative flex flex-col overflow-x-hidden overflow-y-auto">
				
				<div class="w-full">
					<button data-ctrly="off-canvas-menu-target" class="js-off-canvas-menu-control off-canvas-menu__control off-canvas-menu__control--open" title="<?php echo _x('Close navigation', 'button', 'wordpress-boilerplate'); ?>">
						<span class="off-canvas-menu__control-icon" aria-hidden="true"><span></span></span>
						<span class="visually-hidden"><?php echo _x('Close navigation', 'button', 'wordpress-boilerplate'); ?></span>
					</button>
				</div>
				
				<nav class="off-canvas-menu__navigation">
					<?= wordpress_boilerplate_off_canvas_menu(); ?>
				</nav>
			
			</div>
		</section>
	</div>

</div>
