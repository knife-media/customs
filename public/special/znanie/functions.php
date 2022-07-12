<?php
/**
 * znanie: special functions
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Add styles
 */
add_action('wp_enqueue_scripts', function() {
    $version = '1.0';

    // Get page slug
    $slug = basename(__DIR__);

    // Get styles path
    $styles = content_url("customs/special/{$slug}/styles.min.css");

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
    return __DIR__ . '/archive.php';
});


/**
 * Add button to post content
 */
add_action('the_content', function($content) {
    global $post;

    $slug = basename(__DIR__);

    if(has_term($slug, 'special', $post) && is_main_query() && is_singular('post')) {
        $promo_link = sprintf(
            '<figure class="figure figure--promo"><a class="button" href="%s">%s <strong>%s</strong></a>',
            esc_url(get_term_link($slug, 'special')),
            _x('Специальный проект', 'special: znanie', 'knife-customs'),
            _x('общества Знание и Журнала «Нож»', 'special: znanie', 'knife-customs')
        );

        $content = $content . $promo_link;
    }

    return $content;
});
