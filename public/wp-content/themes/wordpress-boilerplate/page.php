<?php get_header(); ?>

<main class="container <?= is_active_sidebar('sidebar-1') ? '' : 'max-w-screen-xl'; ?> grid grid-cols-1 lg:grid-cols-4 gap-16 my-16">
    <div class="col-span-full <?= is_active_sidebar('sidebar-1') ? 'lg:col-span-3' : 'lg:col-span-4'; ?>">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8'); ?>>
                <time class="text-xs leading-none text-zinc-600" datetime="<?= esc_attr(get_the_date('c')); ?>">
                    <?= get_the_date(); ?>
                </time>

                <h1 class="font-serif font-medium text-3xl md:text-4xl xl:text-5xl text-black leading-none mb-4">
                    <?= the_title(); ?>
                </h1>

                <?php if (has_post_thumbnail() && is_singular()) : ?>
                    <div class="mb-4">
                        <?php the_post_thumbnail(); ?>
                    </div>
                <?php endif; ?>
                <div class="wysiwyg">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php get_sidebar(); ?>
    <?php endif; ?>
</main>

<?php get_footer();
