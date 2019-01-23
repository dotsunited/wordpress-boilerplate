<?php get_header(); ?>
	
	<div class="container lg:flex">
		<main class="w-auto lg:w-3/4 mr-8">
			
			<article id="post-<?php the_ID(); ?>" <?php post_class('mb-8'); ?>>
				
				<h1 class="leading-none m-0 mb-4">
					404
				</h1>
				
			</article>
		
		</main>
		
		<?php get_sidebar(); ?>
	</div>

<?php get_footer();
