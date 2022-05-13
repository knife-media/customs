<?php
/**
 * misha: custom functions
 */

if (!defined('WPINC')) {
    die;
}
/**
 * Add custom styles
 */
add_action('wp_enqueue_scripts', function() {
    $version = '1.0';

    // Get styles path
    $styles = plugin_dir_url(__FILE__) . 'styles.min.css';

    if(defined('WP_DEBUG') && true === WP_DEBUG) {
        $version = date('U');
    }

    // Let's add the file
    wp_enqueue_style('knife-custom-' . basename(__DIR__), $styles, ['knife-theme'], $version);
});
