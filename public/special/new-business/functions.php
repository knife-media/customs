<?php
/**
 * new-business: special functions
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
 * Set template for archive posts
 */
add_action('single_template', function($template) {
    return plugin_dir_path(__FILE__) . 'single.php';
});


/**
 * Replace the title in prev post button with hero name
 */
add_action('previous_post_link', function($output, $format, $link, $prev) {
    global $post;

    $slug = basename(__DIR__);

    if(has_term($slug, 'special', $post)) {
        // Check if previous post exists
        if(empty($prev->ID)) {
            $posts = get_posts([
                'special' => $slug,
                'posts_per_page' => 1,
                'orderby' => 'date',
                'order' => 'DESC'
            ]);

            // Check post exists and not same as current
            if(empty($posts[0]->ID) || $posts[0]->ID === $post->ID) {
                return $output;
            }

            $prev = $posts[0];

            // Generate default output
            $output = sprintf('<a href="%s" rel="prev">%s</a>',
                get_permalink($prev->ID),
                get_the_title($prev->ID)
            );
        }

        // Find hero name post meta
        $hero = get_post_meta($prev->ID, 'post-hero', true);

        if($hero) {
            $output = str_replace(get_the_title($prev->ID), $hero, $output);
        }
    }

    return $output;
}, 10, 4);


/**
 * Replace the title in next post button with hero name
 */
add_action('next_post_link', function($output, $format, $link, $next) {
    global $post;

    $slug = basename(__DIR__);

    if(has_term($slug, 'special', $post)) {
        // Check if next post exists
        if(empty($next->ID)) {
            $posts = get_posts([
                'special' => $slug,
                'posts_per_page' => 1,
                'orderby' => 'date',
                'order' => 'ASC'
            ]);

            // Check post exists and not same as current
            if(empty($posts[0]->ID) || $posts[0]->ID === $post->ID) {
                return $output;
            }

            $next = $posts[0];

            // Generate default output
            $output = sprintf('<a href="%s" rel="next">%s</a>',
                get_permalink($next->ID),
                get_the_title($next->ID)
            );
        }

        // Find hero name post meta
        $hero = get_post_meta($next->ID, 'post-hero', true);

        if($hero) {
            $output = str_replace(get_the_title($next->ID), $hero, $output);
        }
    }

    return $output;
}, 10, 4);
