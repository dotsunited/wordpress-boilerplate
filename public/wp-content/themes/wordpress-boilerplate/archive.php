<?php get_header(); ?>

<main class="container <?= is_active_sidebar('sidebar-1') ? '' : 'max-w-(--breakpoint-xl)'; ?> grid grid-cols-1 lg:grid-cols-4 gap-16 my-16">
    <div class="col-span-full <?= is_active_sidebar('sidebar-1') ? 'lg:col-span-3' : 'lg:col-span-4'; ?>">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8'); ?>>
                <time class="text-xs leading-none text-zinc-600" datetime="<?= esc_attr(get_the_date('c')); ?>">
                    <?= get_the_date(); ?>
                </time>

                <h2 class="leading-none">
                    <a class="no-underline hover:underline font-serif font-medium text-2xl md:text-3xl xl:text-4xl text-black" href="<?php the_permalink(); ?>" title="<?= esc_attr(sprintf(__('Permalink to %s', 'wordpress-boilerplate'), the_title_attribute('echo=0'))); ?>" rel="bookmark">
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

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php get_sidebar(); ?>
    <?php endif; ?>
</main>

<?php get_footer();
