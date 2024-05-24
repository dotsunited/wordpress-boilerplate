<?php

add_action('plugins_loaded', function () {
    remove_action('admin_menu', 'gutenberg_menu');
    remove_action('admin_print_scripts-edit.php', 'gutenberg_replace_default_add_new_button');
    remove_action('admin_init', 'gutenberg_add_edit_link_filters');

    // Gutenberg configuration
    // See https://wordpress.org/gutenberg/handbook/extensibility/theme-support/

    // Remove support for block patterns
    remove_theme_support('core-block-patterns');

    // Removes color palettes, eg. for buttons
    add_theme_support('editor-color-palette', []);

    // Disables custom colors through the color picker
    add_theme_support('disable-custom-colors');

    // Add support for borders
    add_theme_support('border');

    // Removes custom font sizes, eg. for paragraphs
    add_theme_support('editor-font-sizes', [
        [
            'name' => __('Extra Small'),
            'size' => '.75rem',
            'slug' => 'xs',
        ],
        [
            'name' => __('Small'),
            'size' => '.875rem',
            'slug' => 'sm',
        ],
        [
            'name' => __('Base'),
            'size' => '1rem',
            'slug' => 'base',
        ],
        [
            'name' => __('Large'),
            'size' => '1.125rem',
            'slug' => 'lg',
        ],
        [
            'name' => __('Extra Large'),
            'size' => '1.25rem',
            'slug' => 'xl',
        ],
        [
            'name' => __('2x Large'),
            'size' => '1.5rem',
            'slug' => '2xl',
        ],
        [
            'name' => __('3x Large'),
            'size' => '1.875rem',
            'slug' => '3xl',
        ],
        [
            'name' => __('4x Large'),
            'size' => '2.25rem',
            'slug' => '4xl',
        ],
        [
            'name' => __('5x Large'),
            'size' => '3rem',
            'slug' => '5xl',
        ],
        [
            'name' => __('6x Large'),
            'size' => '3.75rem',
            'slug' => '6xl',
        ],
        [
            'name' => __('7x Large'),
            'size' => '4.5rem',
            'slug' => '7xl',
        ],
        [
            'name' => __('8x Large'),
            'size' => '6rem',
            'slug' => '8xl',
        ],
        [
            'name' => __('9x Large'),
            'size' => '9rem',
            'slug' => '9xl',
        ]
    ]);
    add_theme_support('disable-custom-font-sizes');
}, 10, 0);

add_action('enqueue_block_editor_assets', function () {
    if (!wp_script_is('wp-edit-widgets') && !wp_script_is('wp-customize-widgets')) {
        wp_enqueue_script(
            'wordpress-boilerplate-gutenberg-blocks-js',
            plugin_dir_url(__FILE__) . 'blocks/assets/blocks.js',
            ['wp-edit-post'],
            md5_file(plugin_dir_path(__FILE__) . 'blocks/assets/blocks.js')
        );
        wp_enqueue_script(
            'wordpress-boilerplate-gutenberg-embed-blocks-reset-js',
            plugin_dir_url(__FILE__) . 'blocks/embeds/reset.js',
            [
                'wp-blocks',
                'wp-dom-ready',
                'wp-edit-post'
            ],
            md5_file(plugin_dir_path(__FILE__) . 'blocks/embeds/reset.js'),
            false
        );
        wp_enqueue_style(
            'wordpress-boilerplate-gutenberg-blocks-css',
            plugin_dir_url(__FILE__) . '/blocks/assets/blocks.css',
            ['wp-edit-post'],
            md5_file(plugin_dir_path(__FILE__) . '/blocks/assets/blocks.css')
        );
    }
});

add_filter('allowed_block_types_all', function () {
    $blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

    // Once a block has been allowed, it is not possible to disallow it again as
    // it might be already used in posts!

    // Remove all core blocks
    $allowed = array_filter($blocks, function ($key) {
        return strpos($key, 'core/') !== 0;
    }, ARRAY_FILTER_USE_KEY);

    // List of allowed core blocks, uncomment to allow
    // For a list of all core blocks see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/core-blocks.md
    $allow = [
        // 'core/archives',
        // 'core/audio',
        // 'core/avatar',
        'core/block',
        'core/button',
        'core/buttons',
        // 'core/calendar',
        // 'core/categories',
        'core/code',
        'core/column',
        'core/columns',
        // 'core/comment-author-avatar',
        // 'core/comment-author-name',
        // 'core/comment-content',
        // 'core/comment-date',
        // 'core/comment-edit-link',
        // 'core/comment-reply-link',
        // 'core/comment-template',
        // 'core/comments',
        // 'core/comments-pagination',
        // 'core/comments-pagination-next',
        // 'core/comments-pagination-numbers',
        // 'core/comments-pagination-previous',
        // 'core/comments-title',
        // 'core/cover',
        // 'core/details',
        'core/embed',
        // 'core/file',
        // 'core/footnotes',
        // 'core/form',
        // 'core/form-input',
        // 'core/form-submission-notification',
        // 'core/form-submit-button',
        'core/freeform',
        'core/gallery',
        'core/group',
        'core/heading',
        // 'core/home-link',
        'core/html',
        'core/image',
        // 'core/latest-comments',
        // 'core/latest-posts',
        // 'core/legacy-widget',
        'core/list',
        'core/list-item',
        // 'core/loginout',
        // 'core/media-text',
        // 'core/missing',
        'core/more',
        // 'core/navigation',
        // 'core/navigation-link',
        // 'core/navigation-submenu',
        // 'core/nextpage',
        // 'core/page-list',
        // 'core/page-list-item',
        'core/paragraph',
        // 'core/pattern',
        // 'core/post-author',
        // 'core/post-author-biography',
        // 'core/post-author-name',
        // 'core/post-comment',
        // 'core/post-comments-count',
        // 'core/post-comments-form',
        // 'core/post-comments-link',
        // 'core/post-content',
        // 'core/post-date',
        // 'core/post-excerpt',
        // 'core/post-featured-image',
        // 'core/post-navigation-link',
        // 'core/post-template',
        // 'core/post-terms',
        // 'core/post-time-to-read',
        // 'core/post-title',
        // 'core/preformatted',
        'core/pullquote',
        // 'core/query',
        // 'core/query-no-results',
        // 'core/query-pagination',
        // 'core/query-pagination-next',
        // 'core/query-pagination-numbers',
        // 'core/query-pagination-previous',
        // 'core/query-title',
        'core/quote',
        // 'core/read-more',
        // 'core/rss',
        // 'core/search',
        'core/separator',
        'core/shortcode',
        // 'core/site-logo',
        // 'core/site-tagline',
        // 'core/site-title',
        // 'core/social-link',
        // 'core/social-links',
        'core/spacer',
        // 'core/table',
        // 'core/table-of-contents',
        // 'core/tag-cloud',
        // 'core/template-part',
        // 'core/term-description',
        // 'core/text-columns',
        // 'core/verse',
        // 'core/video',
        // 'core/widget-group',
    ];

    // Merge allowed blocks
    $allowed = array_merge(array_keys($allowed), $allow);

    return $allowed;
}, 10, 2);
