<?php

add_action('enqueue_block_assets', function () {
    // Dequeue default block styles. Must be included in the asset build.
    wp_dequeue_style('wp-core-blocks');
});
