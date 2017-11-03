<?php get_header(); ?>

<div class="o-scaffolding">
    <div class="o-scaffolding__container">
        <main>
            <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <time class="post__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo get_the_date(); ?>
                    </time>

                    <h1>
                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'wordpress-boilerplate'), the_title_attribute('echo=0'))); ?>" rel="bookmark">
                            <?php echo the_title(); ?>
                        </a>
                    </h1>

                    <?php if (has_post_thumbnail() && is_singular()): ?>
                    <div class="post__thumbnail responsive-img">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <?php endif; ?>

                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>

        </main>
    </div>
</div>

<?php get_footer();
