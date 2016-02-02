<?php get_header(); ?>

<div class="slider">
    <div class="slider__slide" style="background-image: url(<?php echo esc_attr(wordpress_boilerplate_asset('/assets/img/slider/slide1.jpg')); ?>)"></div>
    <div class="slider__slide" style="background-image: url(<?php echo esc_attr(wordpress_boilerplate_asset('/assets/img/slider/slide2.jpg')); ?>)"></div>
    <div class="slider__slide" style="background-image: url(<?php echo esc_attr(wordpress_boilerplate_asset('/assets/img/slider/slide3.jpg')); ?>)"></div>
</div>

<div class="body body--sidebar">
    <div class="body__container">
        <main class="body__main">
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
        <div class="body__sidebar" role="complementary">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer();
