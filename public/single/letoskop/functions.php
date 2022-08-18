<?php
/**
 * letoskop: custom functions
 */

if (!defined('WPINC')) {
    die;
}
/**
 * Add custom styles
 */
add_action('wp_enqueue_scripts', function() {
    $version = '1.1';

    // Get page slug
    $slug = basename(__DIR__);

    // Get styles path
    $styles = content_url("customs/single/{$slug}/styles.min.css");

    if(defined('WP_DEBUG') && true === WP_DEBUG) {
        $version = date('U');
    }

    // Let's add the file
    wp_enqueue_style('knife-custom-' . $slug, $styles, ['knife-theme'], $version);
});
