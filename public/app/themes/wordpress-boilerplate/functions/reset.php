<?php

add_action('init', function () {
    // -- Remove emoji support for old browsers --
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('embed_head', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    add_filter('tiny_mce_plugins', function ($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, ['wpemoji']);
        }

        return [];
    });

    add_filter('emoji_svg_url', function () {
        // Returning null removes the <link rel='dns-prefetch'> tag
        return null;
    });

    // -- Remove unneeded scripts and styles --
    remove_action('wp_head', 'wp_oembed_add_host_js');
    add_filter('wp_default_scripts', function (WP_Scripts $scripts) {
        if (is_admin()) {
            return;
        }

        // Remove jquery-migrate by re-registering jquery dependent only on jquery-core
        $scripts->remove('jquery');
        $scripts->add(
            'jquery',
            false,
            array('jquery-core'),
            false
        );
    });

    // -- Remove some <meta> tags --
    remove_action('wp_head', 'wp_generator');
    add_filter('the_generator', function () {
        return '';
    });
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // -- Remove global comments feed --
    add_filter('feed_links_show_comments_feed', function () {
        return false;
    });

    // -- Re-enable editor on blog homepage --
    add_action('edit_form_after_title', function ($post) {
        if ((string) $post->ID !== (string) get_option('page_for_posts')) {
            return;
        }

        // This (and hook priority of -1000) ensures _wp_posts_page_notice()
        // always runs...
        remove_action('edit_form_after_title', '_wp_posts_page_notice');
        add_action('edit_form_after_title', '_wp_posts_page_notice');

        add_post_type_support('page', 'editor');
    }, -1000);
    add_filter('gutenberg_can_edit_post', function ($can_edit, $post) {
        if ((string) $post->ID !== (string) get_option('page_for_posts')) {
            return $can_edit;
        }

        return true;
    }, 1000, 2);

    // -- Remove editing site icon from the customizer --
    add_action('customize_register', function (WP_Customize_Manager $wp_customize) {
        $wp_customize->remove_control('site_icon');
    }, 20, 1);
});
