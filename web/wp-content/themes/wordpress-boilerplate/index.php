<?php get_header(); ?>

    <div class="page-content page-content--sidebar">
        <main class="page-content__main">
        <?php while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <time class="post-list__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo get_the_date(); ?>
                </time>

                <h1>
                    <ahref="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'wordpress-boilerplate'), the_title_attribute('echo=0'))); ?>" rel="bookmark">
                        <?php echo the_title(); ?>
                    </a>
                </h1>

                <?php the_content(); ?>
            </article>
        <?php endwhile; ?>

        </main>
        <div class="page-content__sidebar" role="complementary">
            <?php get_sidebar(); ?>
        </div>
    </div>

<?php get_footer();
