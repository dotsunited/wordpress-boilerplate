<?php

add_action('after_setup_theme', function () {
    // Gutenberg configuration
    // See https://wordpress.org/gutenberg/handbook/extensibility/theme-support/

    // Add support for widealign images
    add_theme_support('align-wide');

	// Pass an empty array to remove support for color palettes, eg. for buttons.
    add_theme_support('editor-color-palette', [
        [
            'name' => __('Black', 'wordpress-boilerplate'),
            'slug' => 'black',
            'color' => '#252427',
        ],
        [
            'name' => __('Darkest', 'wordpress-boilerplate'),
            'slug' => 'gray-900',
            'color' => '#414549',
        ],
        [
            'name' => __('Darker', 'wordpress-boilerplate'),
            'slug' => 'gray-800',
            'color' => '#697788',
        ],
        [
            'name' => __('Dark', 'wordpress-boilerplate'),
            'slug' => 'gray-600',
            'color' => '#676767',
        ],
        [
            'name' => __('Light', 'wordpress-boilerplate'),
            'slug' => 'gray-400',
            'color' => '#f1f4fd',
        ],
        [
            'name' => __('Grey', 'wordpress-boilerplate'),
            'slug' => 'gray-500',
            'color' => '#b8c2cc',
        ],
        [
            'name' => __('White', 'wordpress-boilerplate'),
            'slug' => 'white',
            'color' => '#fff',
        ],
        [
            'name' => __('Blue', 'wordpress-boilerplate'),
            'slug' => 'blue-500',
            'color' => '#4a7cf6',
        ],[
            'name' => __('Blue Dark', 'wordpress-boilerplate'),
            'slug' => 'blue-600',
            'color' => '#0073C0',
        ],
    ]);
}, 11, 0);

// Overwrite gutenberg block assets
add_filter('the_content', function ($content) {
    // Replace gutenberg palette color classes with tailwind classes.
    // Make sure to not do concatenation of classes because PurgeCSS must detect
    // the strings here!

    return \strtr($content, [
        'has-blue-500-color' => 'text-blue-500',
        'has-blue-600-color' => 'text-blue-600',
        'has-gray-900-color' => 'text-gray-900',
        'has-gray-800-color' => 'text-gray-800',
        'has-gray-600-color' => 'text-gray-600',
        'has-gray-400-color' => 'text-gray-400',
        'has-white-color' => 'text-white',
        'has-black-color' => 'text-black',

        'has-blue-600-background-color' => 'bg-blue-600',
        'has-blue-500-background-color' => 'bg-blue-500',
        'has-gray-900-background-color' => 'bg-gray-900',
        'has-gray-800-background-color' => 'bg-gray-800',
        'has-gray-600-background-color' => 'bg-gray-600',
        'has-gray-400-background-color' => 'bg-gray-400',
        'has-white-background-color' => 'bg-white',
        'has-black-background-color' => 'bg-black',

        'has-blue-600-border-color' => 'border-blue-600 border-t border-b',
        'has-blue-500-border-color' => 'border-blue-500 border-t border-b',
        'has-gray-900-border-color' => 'border-gray-900 border-t border-b',
        'has-gray-800-border-color' => 'border-gray-800 border-t border-b',
        'has-gray-600-border-color' => 'border-gray-600 border-t border-b',
        'has-gray-400-border-color' => 'border-gray-400 border-t border-b',
        'has-white-border-color' => 'border-white border-t border-b',
        'has-black-border-color' => 'border-black border-t border-b',

        'has-sm-font-size' => 'text-sm',
        'has-base-font-size' => 'text-base',
        'has-lg-font-size' => 'text-lg',
        'has-xl-font-size' => 'text-xl',

        'has-shadow-md' => 'shadow-md',
        'has-shadow-lg' => 'shadow-lg',
        'has-no-shadow' => '',

        'wp-block-columns' => 'wp-block-columns flex flex-row flex-wrap -mx-2',

        'are-vertically-aligned-top' => 'items-start',
        'are-vertically-aligned-center' => 'items-center',
        'are-vertically-aligned-bottom' => 'items-end',

        'is-vertically-aligned-center' => 'self-center',
        'is-vertically-aligned-top' => 'self-start',
        'is-vertically-aligned-bottom' => 'self-end'
    ]);

}, 9999);

function wordpress_boilerplate_is_gutenberg_preview()
{
    return defined('REST_REQUEST') && true === REST_REQUEST && 'edit' === $_REQUEST['context'];
}

function _wordpress_boilerplate_gutenberg_render($slug, array $attributes = [], $previewStyle = '')
{
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
    wp_dequeue_style('wp-block-library');
});

// Gutenberg block editor assets
add_action( 'init', 'register_custom_block_style' );

function register_custom_block_style() {
	if( ! function_exists( 'register_block_style' ) ) return;
	
	register_block_style(
		'core/group',
		array(
			'name'			=> 'gray-400-group',
			'label'			=> __( 'Gray Group' ),
			'inline_style'	=> '.wp-block-group.is-style-gray-400-group { background-color: #cbd5e0; }',
		)
	);
};
