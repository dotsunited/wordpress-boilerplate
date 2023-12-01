<?php get_header(); ?>

<div class="container grid grid-cols-1 lg:grid-cols-4 gap-8 my-16">
    <main class="col-span-full lg:col-span-3">
        <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8'); ?>>
            <?= wordpress_boilerplate_render('template-parts/components/content/404'); ?>
        </article>
    </main>

    <?php get_sidebar(); ?>
</div>

<?php get_footer();
