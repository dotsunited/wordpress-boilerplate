<?php

if (class_exists('\Sentry\Options') && class_exists('\Sentry\Event')) {
    add_filter('wp_sentry_options', function (\Sentry\Options $options) {
        $options->setBeforeSendCallback( function ( \Sentry\Event $event ) {
            // Only apply filtering logic for warnings
            if ($event->getLevel() !== \Sentry\Severity::warning()) {
                return $event;
            }

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

                // Check if the filename contains any of the paths
                $pluginPaths = [
                    '/wp-content/plugins/'
                ];
                foreach ( $pluginPaths as $pluginPath ) {
                    if ( $strContainsHelper( $file, $pluginPath ) ) {
                        return null;
                    }
                }
            }

            return $event;
        });

        return $options;
    });
}
