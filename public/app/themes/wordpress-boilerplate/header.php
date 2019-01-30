<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php include __DIR__ . '/../../../favicons/favicons.html'; ?>

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <header class="container py-8 flex items-center justify-between flex-wrap">
            <a href="<?php echo esc_attr(get_home_url()); ?>" class="flex items-center flex-no-shrink text-white mr-6">
                <?php echo wordpress_boilerplate_asset_embed('/logo-dotsunited.svg'); ?>
            </a>

            <nav class="flex flex-grow items-center">
                <?php wp_nav_menu(array(
                    'theme_location' => 'main',
                    'depth' => 1,
                    'fallback_cb' => null,
                    'container' => false,
                    'items_wrap' => '<ul id="%1$s" class="list-reset flex flex-grow %2$s">%3$s</ul>',
                )); ?>
            </nav>
        </header>
