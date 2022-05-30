<?php
/**
 * advertising: custom functions
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Add custom scripts and styles
 */
add_action('wp_enqueue_scripts', function() {
    $version = '1.0';

    // Get page slug
    $slug = basename(__DIR__);

    // Get styles
    $styles = content_url("customs/single/{$slug}/styles.min.css");

    // Get scripts
    $scripts = content_url("customs/single/{$slug}/scripts.min.js");

    if(defined('WP_DEBUG') && true === WP_DEBUG) {
        $version = date('U');
    }

    // Let's add styles
    wp_enqueue_style('knife-custom-' . $slug, $styles, ['knife-theme'], $version);

    // Let's add scripts
    wp_enqueue_script('knife-custom-' . $slug, $scripts, ['knife-theme'], $version, true);
});
