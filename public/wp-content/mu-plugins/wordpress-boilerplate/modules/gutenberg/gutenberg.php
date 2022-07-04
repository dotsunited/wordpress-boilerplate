<?php

add_action('plugins_loaded', function () {
    remove_action('admin_menu', 'gutenberg_menu');
    remove_action('admin_print_scripts-edit.php', 'gutenberg_replace_default_add_new_button');
    remove_action('admin_init', 'gutenberg_add_edit_link_filters');

    // Gutenberg configuration
    // See https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	
	// Remove support for block patterns
	remove_theme_support( 'core-block-patterns' );
	
    // Removes color palettes, eg. for buttons
    add_theme_support('editor-color-palette', []);
    
    // Disables custom colors through the color picker
    add_theme_support('disable-custom-colors');
    
    // Removes custom fot sizes, eg. for paragraphs
    add_theme_support('editor-font-sizes', [
        [
            'name' => __('Small'),
            'size' => 16,
            'slug' => 'sm',
        ],
        [
            'name' => __('Normal'),
            'size' => 18,
            'slug' => 'base',
        ],
        [
            'name' => __('Large'),
            'size' => 21,
            'slug' => 'lg',
        ],
        [
            'name' => __('Extra Large'),
            'size' => 24,
            'slug' => 'xl',
        ]
    ]);
    add_theme_support('disable-custom-font-sizes');
}, 10, 0);

add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'wordpress-boilerplate-gutenberg-blocks-js',
        plugin_dir_url(__FILE__) . 'blocks/assets/blocks.js',
        ['wp-edit-post']
    );
	wp_enqueue_script( 'wordpress-boilerplate-gutenberg-embed-blocks-reset-js',
		plugin_dir_url(__FILE__) . 'blocks/embeds/reset.js',
		[
			'wp-blocks',
			'wp-dom-ready',
			'wp-edit-post'
		],
		'1.0',
		false
	);
    wp_enqueue_style(
        'wordpress-boilerplate-gutenberg-blocks-css',
        plugin_dir_url(__FILE__) . '/blocks/assets/blocks.css',
        ['wp-edit-post']
    );
});

add_filter('allowed_block_types_all', function ($current, $context) {
    if (!\is_array($current)) {
        $current = [];
    }

    // Once a block has been allowed, it is not possible to disallow it again as
    // it might be already used in posts!

    // -- Wordpress Boildeprlate Blocks -----------------------------------------------------------
    $current = \array_merge(
        $current,
        []
    );

    // -- Plugin Blocks ----------------------------------------------------------
    $current = \array_merge(
        $current,
        [
            // --- Dots United Gfiframe Blocks ---------------------------------

            'dotsunited-gfiframe/core',
        ]
    );

    // -- Core Blocks ----------------------------------------------------------
    //
    // Core block list:
    //
    //    var list = wp.blocks.getBlockTypes().map(function(block) {
    //        return "'" + block.name + "',";
    //    }).sort();
    //
    //    console.log(list.join("\n"));
    //
    // See: https://github.com/WordPress/gutenberg/tree/1d95916c1979f426f98ae8239fc3b87cc8aed440/packages/block-library/src
    $current = \array_merge(
        $current,
        [
            // 'core/archives',
            // 'core/audio',
            'core/block',
            'core/buttons',
	        'core/group',
            // 'core/categories',
	        // core/calendar,
	        // 'core/code',
            'core/column',
            'core/columns',
            // 'core/cover-image',
            // 'core/embed',
            // 'core/file',
            'core/freeform', // Classic editor
            // 'core/gallery',
            'core/heading',
            // 'core/html',
            'core/image',
            // 'core/latest-comments',
            // 'core/latest-posts',
            'core/list',
            'core/more',
            // 'core/nextpage',
            'core/paragraph',
            // 'core/preformatted',
            // 'core/pullquote',
            // 'core/quote',
            // 'core/separator',
            // 'core/shortcode',
            // 'core/spacer',
            // 'core/subhead',
	        // 'core/social-link',
	        // 'core/social-links',
            // 'core/table',
            // 'core/text-columns',
            // 'core/verse',
            // 'core/video',
	        // 'core/social-link',
	        // 'core/social-links',
	        // Allow single/disallow single embeds not possible anymore: https://github.com/WordPress/gutenberg/issues/25676
            // 'core-embed/animoto',
            // 'core-embed/cloudup',
            // 'core-embed/collegehumor',
            // 'core-embed/dailymotion',
            // 'core-embed/facebook',
            // 'core-embed/flickr',
            // 'core-embed/funnyordie',
            // 'core-embed/hulu',
            // 'core-embed/imgur',
            // 'core-embed/instagram',
            // 'core-embed/issuu',
            // 'core-embed/kickstarter',
            // 'core-embed/meetup-com',
            // 'core-embed/mixcloud',
            // 'core-embed/photobucket',
            // 'core-embed/polldaddy',
            // 'core-embed/reddit',
            // 'core-embed/reverbnation',
            // 'core-embed/screencast',
            // 'core-embed/scribd',
            // 'core-embed/slideshare',
            // 'core-embed/smugmug',
            // 'core-embed/soundcloud',
            // 'core-embed/speaker',
            // 'core-embed/spotify',
            // 'core-embed/ted',
            // 'core-embed/tumblr',
            // 'core-embed/twitter',
            // 'core-embed/videopress',
            // 'core-embed/vimeo',
            // 'core-embed/wordpress',
            // 'core-embed/wordpress-tv',
            // 'core-embed/youtube',
        ]
    );

    return $current;
}, 10, 2);
