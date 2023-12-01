<?php

add_action('after_setup_theme', function () {
    // Gutenberg configuration
    // See https://wordpress.org/gutenberg/handbook/extensibility/theme-support/

    // Add support for widealign images
    add_theme_support('align-wide');

    // Add support for link color
    add_theme_support('link-color');

    // Disable support for gradients
    add_theme_support('editor-gradient-presets', []);
    add_theme_support('disable-custom-gradients', true);

    // Pass an empty array to remove support for color palettes, eg. for buttons.
    add_theme_support('editor-color-palette', [
        [
            'name' => __('Transparent', 'wordpress-boilerplate'),
            'slug' => 'transparent',
            'color' => '#ffffff00',
        ],
        [
            'name' => __('White', 'wordpress-boilerplate'),
            'slug' => 'white',
            'color' => '#ffffff',
        ],
        [
            'name' => __('Zinc 100', 'wordpress-boilerplate'),
            'slug' => 'zinc-100',
            'color' => '#f4f4f5',
        ],
        [
            'name' => __('Zinc 200', 'wordpress-boilerplate'),
            'slug' => 'zinc-200',
            'color' => '#e4e4e7',
        ],
        [
            'name' => __('Zinc 300', 'wordpress-boilerplate'),
            'slug' => 'zinc-300',
            'color' => '#d4d4d8',
        ],
        [
            'name' => __('Black', 'wordpress-boilerplate'),
            'slug' => 'black',
            'color' => '#000000',
        ],
        [
            'name' => __('Red 500', 'wordpress-boilerplate'),
            'slug' => 'dotsunited-red-500',
            'color' => '#c9462a',
        ]
    ]);
}, 11, 0);

// Overwrite gutenberg block assets
add_filter('the_content', function ($content) {
    // Make sure to not do concatenation of classes because PurgeCSS must detect
    // the strings here!

    return \strtr($content, [
        'has-sm-font-size' => 'text-sm',
        'has-base-font-size' => 'text-base',
        'has-lg-font-size' => 'text-lg',
        'has-xl-font-size' => 'text-xl',
    ]);
}, 9999);

function wordpress_boilerplate_is_gutenberg_preview() {
    return defined('REST_REQUEST') && true === REST_REQUEST && 'edit' === $_REQUEST['context'];
}

function _wordpress_boilerplate_gutenberg_render($slug, array $attributes = [], $previewStyle = '') {
    if (wordpress_boilerplate_is_gutenberg_preview()) {
        return '<div style="width:100%;' . esc_attr($previewStyle) . '"><img style="display:block;margin:auto;" src="' . get_template_directory_uri() . '/img/block-preview/' . $slug . '.png"></div>';
    }

    return wordpress_boilerplate_render('template-parts/blocks/' . $slug, $attributes);
}

// custom block registration
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

    // wp_dequeue_style('wp-block-library');
});

add_action('enqueue_block_editor_assets', function () {
    // Enqueue editor UI style.
    wp_enqueue_style('slug-editor-ui-style', get_theme_file_uri('vendor/gutenberg/editor-styles.css'), [], md5_file(get_theme_file_path('vendor/gutenberg/editor-styles.css')));
});

// Gutenberg block editor assets
add_action('init', 'register_custom_block_style');

function register_custom_block_style() {
    if (!function_exists('register_block_style')) return;

    register_block_style(
        'core/group',
        [
            'name'            => 'zinc-300-group',
            'label'           => __('Zinc 300 Group'),
            'inline_style'    => '.wp-block-group.is-style-zinc-300-group { background-color: #d4d4d8; }',
        ]
    );
};
