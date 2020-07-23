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

/*
 * Enable svg media upload
 */
function wordpress_boilerplate_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'wordpress_boilerplate_mime_types');

// Bug workaround https://blog.kulturbanause.de/2013/05/svg-dateien-in-die-wordpress-mediathek-hochladen/
function wordpress_boilerplate_ignore_upload_ext($checked, $file, $filename, $mimes){
	
	if(!$checked['type']){
		$wp_filetype = wp_check_filetype( $filename, $mimes );
		$ext = $wp_filetype['ext'];
		$type = $wp_filetype['type'];
		$proper_filename = $filename;
		
		if($type && 0 === strpos($type, 'image/') && $ext !== 'svg'){
			$ext = $type = false;
		}
		
		$checked = compact('ext','type','proper_filename');
	}
	
	return $checked;
}

add_filter('wp_check_filetype_and_ext', 'wordpress_boilerplate_ignore_upload_ext', 10, 4);
