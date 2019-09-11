<h1 class="leading-tight mb-2"><?php _e('Sorry, that page does not exist.', 'wordpress-boilerplate'); ?></h1>

<p class="font-bold"><?php _e('The page you want to access does not exist, which may have these reasons:', 'wordpress-boilerplate'); ?></p>

<ul>
	<li><?php _e('You made a typo when entering the web address.', 'wordpress-boilerplate'); ?></li>
	<li><?php _e('You clicked on a link that is not correct.', 'wordpress-boilerplate'); ?></li>
</ul>

<p class="font-bold"><?php _e('What can you do? There are several options...', 'wordpress-boilerplate'); ?></p>

<ul>
	<li><a href="javascript:history.back()" title="<?php _e('Back to previous page', 'wordpress-boilerplate'); ?>"><?php _e('Back', 'wordpress-boilerplate'); ?></a> <?php _e('to previous page', 'wordpress-boilerplate'); ?></li>
	<li><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php _e('Visit frontpage', 'wordpress-boilerplate'); ?>"><?php _e('Visit frontpage', 'wordpress-boilerplate'); ?></a></li>
	<li><?php _e('Find the correct page out of the navigation.', 'wordpress-boilerplate'); ?></li>
	<li>
		<?php _e('Try the search function', 'wordpress-boilerplate'); ?>
		<?php get_search_form(); ?>
	</li>
</ul>
