<?php

if (class_exists('\Sentry\Options') && class_exists('\Sentry\Event')) {
    add_filter('wp_sentry_options', function (\Sentry\Options $options) {
        $options->setBeforeSendCallback( function ( \Sentry\Event $event ) {
            $exceptions = $event->getExceptions();
    
            // No exceptions in the event? Send the event to Sentry, it's most likely a log message
            if ( empty( $exceptions ) ) {
                return $event;
            }
    
            $stacktrace = $exceptions[0]->getStacktrace();
    
            // No stacktrace in the first exception? Send it to Sentry just to be safe then
            if ( $stacktrace === null ) {
                return $event;
            }
    
            // Little helper and fallback for PHP versions without the str_contains function
            $strContainsHelper = function ( $haystack, $needle ) {
                if ( function_exists( 'str_contains' ) ) {
                    return str_contains( $haystack, $needle );
                }
    
                return $needle !== '' && mb_strpos( $haystack, $needle ) !== false;
            };

            // Filter out the stacktrace frames that are in plugins
            foreach ( $stacktrace->getFrames() as $frame ) {
                $file = $frame->getFile();
    
                if ( $file === null ) {
                    continue;
                }
    
                // Check if the filename contains the path to the plugins directory
                if ( $strContainsHelper( $file, '/wp-content/plugins/' ) ) {
                    return null;
                }
            }

            return $event;
        });

        return $options;
    });
}
