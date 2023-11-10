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
    <header class="bg-white shadow-lg z-20 sticky top-0 left-0 right-0 w-full">

        <div class="mx-auto relative">
		    <?= wordpress_boilerplate_render('template-parts/components/header/desktop', []); ?>
		    <?= wordpress_boilerplate_render('template-parts/components/header/mobile', []); ?>
        </div>

    </header>
