<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php include __DIR__ . '../../../../favicons/favicons.html'; ?>

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
    <header class="bg-white shadow-header z-20 relative lg:fixed lg:top-0 lg:left-0 lg:right-0 w-full">

        <div class="mx-auto relative">
		    <?php echo wordpress_boilerplate_render('template-parts/components/header/desktop', []); ?>
		    <?php echo wordpress_boilerplate_render('template-parts/components/header/mobile', []); ?>
        </div>

    </header>
