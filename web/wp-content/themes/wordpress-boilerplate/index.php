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
                    <time class="post-list__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo get_the_date(); ?>
                    </time>

                    <h1>
                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'wordpress-boilerplate'), the_title_attribute('echo=0'))); ?>" rel="bookmark">
                            <?php echo the_title(); ?>
                        </a>
                    </h1>

                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>

            <div class="teaser">
                <a href="#" class="teaser__item">
                    <h2 class="teaser__title">Teaser 1</h2>
                    <div class="teaser__body">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at lectus at turpis vulputate placerat.
                            Nam efficitur leo porta, cursus massa eu, malesuada erat. Maecenas pretium justo ac porttitor mollis.
                        </p>
                    </div>
                </a>
                <a href="#" class="teaser__item">
                    <h2 class="teaser__title">Teaser 2</h2>
                    <div class="teaser__body">
                        <p>
                            Proin vel sapien sem. Mauris eu enim felis. Ut fermentum suscipit leo, in viverra arcu ornare in.
                            Nulla pretium aliquam ipsum, sed scelerisque nunc ultricies pharetra. Ut nisl erat, faucibus at viverra at, dignissim in mi.
                        </p>
                    </div>
                </a>
                <a href="#" class="teaser__item">
                    <h2 class="teaser__title">Teaser 3</h2>
                    <div class="teaser__body">
                        <p>
                            Quisque urna neque, consectetur lobortis mauris quis, vehicula porta ante. Cras a placerat velit.
                            Integer viverra, mi quis blandit posuere, velit erat posuere nibh, ac fringilla diam augue egestas nisi.
                        </p>
                    </div>
                </a>
                <a href="#" class="teaser__item">
                    <h2 class="teaser__title">Teaser 4</h2>
                    <div class="teaser__body">
                        <p>
                            Integer viverra, mi quis blandit posuere, velit erat posuere nibh, ac fringilla diam augue egestas nisi.
                            Nulla pellentesque felis non pharetra vehicula. Phasellus tristique efficitur lacinia. Etiam sagittis massa ac urna consequat dignissim.
                            Suspendisse potenti.
                        </p>
                    </div>
                </a>
            </div>

        </main>
        <div class="body__sidebar" role="complementary">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer();
