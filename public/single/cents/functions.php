<?php
/**
 * cents: custom functions
 */

if (!defined('WPINC')) {
    die;
}


/**
 * Set template for single posts
 */
add_filter('page_template', function($template) {
    return __DIR__ . '/single.php';
});


/**
 * Add custom styles
 */
add_action('wp_enqueue_scripts', function() {
    $version = '1.0';

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


/**
 * Update entry-content with cents posts
 */
add_filter('the_content', function($content) {
    $page_id = get_the_ID();

    // Get post cents from post meta
    $cents = get_post_meta($page_id, Knife_Customs_Cents::$meta_cents, true);

    if(empty($cents)) {
        return $content;
    }

    // Create new content from cards
    $content = Knife_Customs_Cents::create_cards($cents, '</div><div class="entry-cents">');

    return $content;
}, 5);

/**
 * Cents customs class
 */
class Knife_Customs_Cents {
    /**
     * Post meta to store cents posts
     *
     * @access  public
     * @var     string
     */
    public static $meta_cents = '_knife-cents';


    /**
     * Create cards using post cents data
     */
    public static function create_cards($cents, $separator) {
        $cards = [];

        foreach($cents as $i => $cent) {
            $index = count($cents) - $i;

            $anchor = sprintf(
                '<h2 class="entry-cents__anchor" id="%1$d"><em>%2$s</em></h2>',
                absint($index), esc_html($cent['title'])
            );

            // Add paragraph to content
            $content = wpautop(esc_html($cent['content']));

            // Add source button if exists
            if(!empty($cent['link']) && !empty($cent['source'])) {
                $content = $content . Knife_Customs_Cents::create_button($cent['link'], $cent['source']);
            }

            // Append share buttons
            if(method_exists('Knife_Share_Buttons', 'get_settings')) {
                $content = $content . Knife_Customs_Cents::append_share($index, $cent);
            }

            // Wrap content
            $content = sprintf('<div class="entry-cents__content">%s</div>', $content);

            // Add heading to content
            $cards[] = $anchor . $content;
        }

        return implode($separator, $cards);
    }


    /**
     * Append share buttons
     */
    private static function append_share($index, $cent) {
        $settings = Knife_Share_Buttons::get_settings();

        // Remove facebook here
        unset($settings['facebook']);

        // Update default settings
        foreach($settings as $network => &$data) {
            $title = $cent['title'];

            // Update title for network
            if($network === 'telegram') {
                $title = str_replace(["\n", "  "], " ", $cent['content']);
            }

            // Set sharing ling with hash param
            $link = esc_url(get_permalink() . "#" . $index);

            $data['link'] = sprintf($data['link'], urlencode($link), urlencode($title));
        }

        $share = sprintf(
            '<figure class="figure figure--share"><div class="share">%s</div></figure>',
            Knife_Share_Buttons::get_buttons($settings)
        );

        return $share;
    }


    /**
     * Append button to cards if need
     */
    private static function create_button($link, $source) {
        $button = sprintf(
            '<a class="button" href="%2$s" target="_blank" data-before="%3$s">%1$s</a>',
            esc_html($source), esc_url($link),
            __('Источник ', 'knife-customs')
        );

        $figure = sprintf(
            '<figure class="figure figure--source">%s</figure>',
            wp_targeted_link_rel($button)
        );

        return $figure;
    }
}
