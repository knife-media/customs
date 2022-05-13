<?php
/**
 * social-promo: custom functions
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Add custom styles
 */
add_action('wp_enqueue_scripts', function() {
    $slug = basename(__DIR__);

    // Get styles
    $styles = plugin_dir_url(__FILE__) . 'styles.min.css';

    // Get scripts
    $scripts = plugin_dir_url(__FILE__) . 'scripts.min.js';

    // Set styles version
    $version = wp_get_theme()->get('Version');

    if(defined('WP_DEBUG') && true === WP_DEBUG) {
        $version = date('U');
    }

    // Let's add styles
    wp_enqueue_style('knife-custom-' . basename(__DIR__), $styles, ['knife-theme'], $version);

    // Let's add scripts
    wp_enqueue_script('knife-custom-' . basename(__DIR__), $scripts, ['knife-theme'], $version, true);
});
