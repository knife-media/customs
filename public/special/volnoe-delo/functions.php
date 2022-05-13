<?php
/**
 * volnoe delo: special functions
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


/**
 * Add button to post content
 */
add_action('the_content', function($content) {
    global $post;

    $slug = basename(__DIR__);

    if(has_term($slug, 'special', $post) && is_main_query() && is_singular('post')) {
        $promo_link = sprintf(
            '<figure class="figure figure--promo"><a class="button" href="%s"><strong>%s</strong> %s</a>',
            esc_url(get_term_link($slug, 'special')),
            _x('Специальный проект', 'special: volnoe-delo', 'knife-customs'),
            _x('Фонда «Вольное дело» Дерипаски и Журнала «Нож»', 'special: volnoe delo', 'knife-customs')
        );

        $content = $content . $promo_link;
    }

    return $content;
});
