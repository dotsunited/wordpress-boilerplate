<?php

// Filter except length to x words.
function wordpress_boilerplate_custom_excerpt_length( $length ) {
	return 10;
}

add_filter( 'excerpt_length', 'wordpress_boilerplate_custom_excerpt_length', 999 );

// Custom excerpt more sign
function wordpress_boilerplate_excerpt_more( $more ) {
	return '…';
}

add_filter( 'excerpt_more', 'wordpress_boilerplate_excerpt_more' );
