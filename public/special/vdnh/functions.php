<?php
/**
 * vdnh: special functions
 */

if (!defined('WPINC')) {
    die;
}


/**
 * Add styles
 */
add_action('wp_enqueue_scripts', function() {
    $version = '1.0';

    // Get styles path
    $styles = plugin_dir_url(__FILE__) . 'styles.min.css';

    if(defined('WP_DEBUG') && true === WP_DEBUG) {
        $version = date('U');
    }

    // Let's add the file if exists
    wp_enqueue_style('knife-special-' . basename(__DIR__), $styles, ['knife-theme'], $version);
});


/**
 * Set template for archive posts
 */
add_action('archive_template', function($template) {
    return plugin_dir_path(__FILE__) . 'archive.php';
});