<?php
/**
 * Knife Customs
 *
 * Upgrade posts and archives with custom functions and styles
 */

if (!defined('WPINC')) {
    die;
}

class Knife_Customs {
    /**
     * Init function instead of constructor
     */
    public static function load_module() {
        // Load custom post functions
        add_action('wp', [__CLASS__, 'inject_customs']);

        // Try to update special templates
        add_action('wp', [__CLASS__, 'inject_special_single'], 8);

        // Try to update special  templates
        add_action('wp', [__CLASS__, 'inject_special_archive'], 8);
    }


    /**
     * Load custom post functions only for current post name
     */
    public static function inject_customs() {
        $object = get_queried_object();

        if($object === null) {
            return;
        }

        if(!is_singular()) {
            return;
        }

        // Try to find top level parent
        if(!empty($object->post_parent)) {
            $ancestors = get_post_ancestors($object);

            if(!empty($ancestors)) {
                $object = get_post(array_pop($ancestors));
            }
        }

        if(empty($object->post_name)) {
            return;
        }

        // Get current post name
        $include = __DIR__ . "/single/{$object->post_name}";

        // Let's add the file if exists
        if(file_exists($include . '/functions.php')) {
            include_once $include . '/functions.php';
        }
    }


    /**
     * Try to require custom functions.php for special terms archives
     */
    public static function inject_special_archive() {
        if(!is_tax('special')) {
            return;
        }

        $term = get_queried_object();

        if(!empty($term->slug)) {
            $include = __DIR__ . "/special/{$term->slug}";

            if(file_exists($include . '/functions.php')) {
                include_once $include . '/functions.php';
            }
        }
    }


    /**
     * Try to require custom functions.php for special terms singles
     */
    public static function inject_special_single() {
        if(!is_singular()) {
            return;
        }

        $post_id = get_queried_object_id();

        if(!has_term('', 'special', $post_id)) {
            return;
        }

        // Loop over all tax terms
        foreach(get_the_terms($post_id, 'special') as $term) {
            $ancestors = get_ancestors($term->term_id, 'special', 'taxonomy');

            // Get parent if exists
            if(!empty($ancestors)) {
                $term = get_term($ancestors[0], 'special');
            }

            $include = __DIR__ . "/special/{$term->slug}";

            if(file_exists($include . '/functions.php')) {
                include_once $include . '/functions.php';
            }
        }
    }
}

/**
 * Load current module environment
 */
Knife_Customs::load_module();
