<?php get_header(); ?>

<main class="container <?= is_active_sidebar('sidebar-1') ? '' : 'max-w-screen-xl'; ?> grid grid-cols-1 lg:grid-cols-4 gap-16 my-16">
    <div class="col-span-full <?= is_active_sidebar('sidebar-1') ? 'lg:col-span-3' : 'lg:col-span-4'; ?>">
        <?php if (have_posts()) :  ?>
            <header class="w-full">
                <h1 class="leading-none m-0 mb-2">
                    <?php _e('Search results for:', 'wordpress-boilerplate'); ?>
                </h1>
                <div class="text-lg font-semibold"><?= get_search_query(); ?></div>
            </header>

            <div class="mt-16">
                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8'); ?>>

                        <h2 class="leading-none">
                            <a class="no-underline hover:underline font-serif text-3xl text-black" href="<?php the_permalink(); ?>" title="<?= esc_attr(sprintf(__('Permalink to %s', 'wordpress-boilerplate'), the_title_attribute('echo=0'))); ?>" rel="bookmark">
                                <?= the_title(); ?>
                            </a>
                        </h2>

                        <?php if (has_post_thumbnail() && is_singular()) : ?>
                            <div class="mb-4">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        <?php endif; ?>
                        <div class="wysiwyg">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <?= wordpress_boilerplate_render('template-parts/components/content/none'); ?>
        <?php endif; ?>
    </div>

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php get_sidebar(); ?>
    <?php endif; ?>
</main>

<?php get_footer();
