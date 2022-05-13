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

    // Get styles
    $styles = plugin_dir_url(__FILE__) . 'styles.min.css';

    // Get scripts
    $scripts = plugin_dir_url(__FILE__) . 'scripts.min.js';

    if(defined('WP_DEBUG') && true === WP_DEBUG) {
        $version = date('U');
    }

    // Let's add styles
    wp_enqueue_style('knife-custom-' . basename(__DIR__), $styles, ['knife-theme'], $version);

    // Let's add scripts
    wp_enqueue_script('knife-custom-' . basename(__DIR__), $scripts, ['knife-theme'], $version, true);
});
