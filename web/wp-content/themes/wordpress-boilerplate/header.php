<!doctype html>
<!--[if lt IE 9]>      <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?> data-theme-url="<?php echo esc_attr(get_template_directory_uri()); ?>">
        <header class="header">
            <div class="header__container">
                <a class="header__logo" href="<?php echo esc_attr(get_home_url()); ?>">
                    <!--[if lt IE 9]><img src="<?php echo esc_attr(get_template_directory_uri()); ?>/assets/img/logo-dotsunited.png" alt="<?php esc_attr(get_bloginfo('name', 'display')); ?>"/><![endif]-->
                    <!--[if gt IE 8]><img src="<?php echo esc_attr(get_template_directory_uri()); ?>/assets/img/logo-dotsunited.svg" alt="<?php esc_attr(get_bloginfo('name', 'display')); ?>"/><![endif]-->
                    <!--[if !IE]> --><img src="<?php echo esc_attr(get_template_directory_uri()); ?>/assets/img/logo-dotsunited.svg" alt="<?php esc_attr(get_bloginfo('name', 'display')); ?>"/><!-- <![endif]-->
                </a>

                <div class="header__navigation">
                    <nav class="desktop-navigation">
                        <?php wp_nav_menu(array(
                            'theme_location' => 'main',
                            'container' => false,
                            'menu_class' => 'desktop-navigation__list',
                        )); ?>
                    </nav>
                </div>

                <div class="header__off-canvas-navigation">
                    <button aria-hidden="true" class="off-canvas-navigation-button" data-off-canvas-navigation-toggle>
                        <span><span></span></span>
                    </button>

                    <div aria-hidden="true" class="off-canvas-navigation-backdrop" data-off-canvas-navigation-toggle="#off-canvas-navigation-menu"></div>

                    <nav aria-hidden="true" class="off-canvas-navigation-menu">
                        <?php wp_nav_menu(array(
                            'theme_location' => 'main',
                            'container' => false,
                            'menu_class' => 'off-canvas-navigation-menu__list',
                            'depth' => 1,
                        )); ?>
                    </nav>
                </div>
            </div>
        </header>
