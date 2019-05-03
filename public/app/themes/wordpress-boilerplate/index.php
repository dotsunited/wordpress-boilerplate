<?php get_header(); ?>

<div class="container lg:flex">
    <main class="w-auto lg:w-3/4 mr-8">
    <?php while (have_posts()): the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8'); ?>>
            <time class="text-xs leading-none text-gray-600" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                <?php echo get_the_date(); ?>
            </time>

            <h1 class="leading-none m-0 mb-4">
                <a class="no-underline hover:underline text-black" href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'wordpress-boilerplate'), the_title_attribute('echo=0'))); ?>" rel="bookmark">
                    <?php echo the_title(); ?>
                </a>
            </h1>

        <?php if (has_post_thumbnail() && is_singular()): ?>
            <div class="mb-4">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>
            <div class="wysiwyg">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>

    </main>

    <?php get_sidebar(); ?>
</div>

<?php get_footer();
