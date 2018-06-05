<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php include __DIR__.'/../../../favicons/favicons.html'; ?>

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <header class="header">
            <div class="header__container">
                <a class="header__logo" href="<?php echo esc_attr(get_home_url()); ?>">
                    <?php echo wordpress_boilerplate_asset_embed('/logo-dotsunited.svg'); ?>
                </a>

                <div class="header__navigation">
                    <nav class="navigation">
                        <?php wp_nav_menu(array(
                            'theme_location' => 'main',
                            'container' => false,
                            'menu_class' => 'navigation__list'
                        )); ?>
                    </nav>
                </div>
            </div>
        </header>
