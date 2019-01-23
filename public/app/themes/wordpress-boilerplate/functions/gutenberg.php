<?php

add_action('after_setup_theme', function () {
    // Gutenberg configuration
    // See https://wordpress.org/gutenberg/handbook/extensibility/theme-support/

    // Add support for widealign images
    add_theme_support('align-wide');

    // Pass an empty array to remove support for color palettes, eg. for buttons.
    /*
    add_theme_support('editor-color-palette', [
        [
            'name' => __('Black', 'bvn'),
            'slug' => 'black',
            'color' => '#252427',
        ],
        [
            'name' => __('Darkest', 'bvn'),
            'slug' => 'darkerest',
            'color' => '#414549',
        ],
        [
            'name' => __('Darker', 'bvn'),
            'slug' => 'darker',
            'color' => '#697788',
        ],
        [
            'name' => __('Dark', 'bvn'),
            'slug' => 'dark',
            'color' => '#676767',
        ],
        [
            'name' => __('Light', 'bvn'),
            'slug' => 'light',
            'color' => '#f1f4fd',
        ],
        [
            'name' => __('Grey', 'bvn'),
            'slug' => 'grey',
            'color' => '#b8c2cc',
        ],
        [
            'name' => __('White', 'bvn'),
            'slug' => 'white',
            'color' => '#fff',
        ],
        [
            'name' => __('Blue', 'bvn'),
            'slug' => 'blue',
            'color' => '#4a7cf6',
        ],[
            'name' => __('Blue Dark', 'bvn'),
            'slug' => 'blue-dark',
            'color' => '#0073C0',
        ],
    ]);
    */
}, 11, 0);

// Overwrite gutenberg block assets
add_filter('the_content', function ($content) {
    // Replace gutenberg palette color classes with tailwind classes.
    // Make sure to not do concatenation of classes because PurgeCSS must detect
    // the strings here!
    /*
    return \strtr($content, [
        'has-blue-color' => 'text-blue',
        'has-blue-dark-color' => 'text-blue-dark',
        'has-darkerest-color' => 'text-grey-darkest',
        'has-darker-color' => 'text-grey-darker',
        'has-dark-color' => 'text-grey-dark',
        'has-light-color' => 'text-grey-light',
        'has-white-color' => 'text-white',
        'has-black-color' => 'text-black',

        'has-blue-dark-background-color' => 'bg-blue-dark',
        'has-blue-background-color' => 'bg-blue',
        'has-darkest-background-color' => 'bg-grey-darkest',
        'has-darker-background-color' => 'bg-grey-darker',
        'has-dark-background-color' => 'bg-grey-dark',
        'has-light-background-color' => 'bg-grey-light',
        'has-white-background-color' => 'bg-white',
        'has-black-background-color' => 'bg-black',

        'has-blue-dark-border-color' => 'border-blue-dark border-t border-b',
        'has-blue-border-color' => 'border-blue border-t border-b',
        'has-darkest-border-color' => 'border-grey-darkest border-t border-b',
        'has-darker-border-color' => 'border-grey-darker border-t border-b',
        'has-dark-border-color' => 'border-grey-dark border-t border-b',
        'has-light-border-color' => 'border-grey-light border-t border-b',
        'has-white-border-color' => 'border-white border-t border-b',
        'has-black-border-color' => 'border-black border-t border-b',

        'has-sm-font-size' => 'text-sm',
        'has-base-font-size' => 'text-base',
        'has-lg-font-size' => 'text-lg',
        'has-xl-font-size' => 'text-xl',

        'has-shadow-md' => 'shadow-md',
        'has-shadow-lg' => 'shadow-lg',
        'has-no-shadow' => '',
    ]);
    */
}, 9999);

function wordpress_boilerplate_is_gutenberg_preview()
{
    return (
        defined('REST_REQUEST') &&
        true === REST_REQUEST &&
        'edit' === $_REQUEST['context']
    );
}

function _wordpress_boilerplate_gutenberg_render($slug, array $attributes = [], $previewStyle = '')
{

    if (wordpress_boilerplate_is_gutenberg_preview()) {
        return '<div style="width:100%;' . esc_attr($previewStyle) . '"><img style="display:block;margin:auto;" src="' . get_template_directory_uri() . '/img/block-preview/' . $slug . '.png"></div>';
    }

    return wordpress_boilerplate_render('template-parts/blocks/' . $slug, $attributes);
}

// demo custom block registration
/*
register_block_type('wordpress-boilerplate/demo', [
    'attributes' => [
        'className' => [
            'type' => 'string',
        ],
        'align' => [
            'type' => 'string',
        ],
    ],
    'render_callback' => function (array $attributes) {
        return _wordpress_boilerplate_gutenberg_render(
            'demo',
            [
                'className' => isset($attributes['className']) ? $attributes['className'] : null,
                'align' => isset($attributes['align']) ? $attributes['align'] : null,
            ],
            'background:#f3f4f4;'
        );
    },
]);
*/

add_action('enqueue_block_assets', function () {
    // Dequeue default block styles. Must be included in the asset build.
    // Must probably be extended to also dequeue additional block styles
    // registered by plugins etc.
    wp_dequeue_style('wp-block-library');
});

// Demo Gutenberg block editor assets
/*
add_action('enqueue_block_editor_assets', function () {

    add_action('admin_footer', function () {
        ?>
        <script>
            wp.blocks.registerBlockStyle( 'wordpress-boilerplate/container',
                { name: 'shadow-none', label: 'No Shadow' }
            );
            wp.blocks.registerBlockStyle( 'wordpress-boilerplate/container',
                { name: 'shadow-md', label: 'Medium Shadow' }
            );
            wp.blocks.registerBlockStyle( 'wordpress-boilerplate/container',
                { name: 'shadow-lg', label: 'Large Shadow' }
            );
        </script>
        <style>

        </style>
        <?php
    }, 1000);
});
*/
