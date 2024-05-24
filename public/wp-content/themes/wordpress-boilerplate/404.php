<?php get_header(); ?>

<main class="container <?= is_active_sidebar('sidebar-1') ? '' : 'max-w-screen-xl'; ?> grid grid-cols-1 lg:grid-cols-4 gap-16 my-16">
    <div class="col-span-full <?= is_active_sidebar('sidebar-1') ? 'lg:col-span-3' : 'lg:col-span-4'; ?>">
        <article id="post-<?php the_ID(); ?>" <?php post_class('wysiwyg mb-8'); ?>>
            <?= wordpress_boilerplate_render('template-parts/components/content/404'); ?>
        </article>
    </div>

    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php get_sidebar(); ?>
    <?php endif; ?>
</main>

<?php get_footer();
