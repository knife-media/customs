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

        // Try to update special templates
        add_action('wp', [__CLASS__, 'inject_special_archive'], 8);

        // Inject secret-wizard
        add_action('wp', [__CLASS__, 'inject_wizard'], 8);
    }


    /**
     * Load secret-wizard functions
     */
    public static function inject_wizard() {
        $version = '1.1';

        // Get custom slug
        $slug = 'secret-wizard';

        // Get styles
        $styles = content_url("customs/common/{$slug}/styles.min.css");

        // Get scripts
        $scripts = content_url("customs/common/{$slug}/scripts.min.js");

        if(defined('WP_DEBUG') && true === WP_DEBUG) {
            $version = date('U');
        }

        // Let's add styles
        wp_enqueue_style('knife-custom-' . $slug, $styles, ['knife-theme'], $version);

        // Let's add scripts
        wp_enqueue_script('knife-custom-' . $slug, $scripts, ['knife-theme'], $version, true);

        $options = [
            'url' => '/feature/secret-wizard/requests/',
            'welcome' => [
                'excerpts' => [
                    __('Могут ли когнитивная психология и эволюционная биология объяснить устройство наших сообществ и формирование религиозных верований? Редакция журнала «Нож» уверена, что да.', 'knife-customs'),
                    __('Задайте вопрос оракулу и нажмите на кнопку, чтобы узнать ответ.', 'knife-customs'),
                ],
                'button' => __('Узнать', 'knife-customs'),
                'label' => __('про мох в волшебном лесу', 'knife-customs'),
            ],
            'selection' => [
                'title' => __('Выберите 4 символа', 'knife-customs'),
                'label' => __('как чувствуете в порядке важности', 'knife-customs'),
                'button' => __('Вперед', 'knife-customs'),
            ],
            'error' => [
                'title' => __('Не получилось', 'knife-customs'),
                'text'  => __('Сегодня оракул не может вам ответить. Попробуйте еще раз или приходите завтра.', 'knife-customs'),
            ],
            'repeated' => __('Не испытывайте судьбу дважды. Задайте следующий вопрос оракулу завтра, а пока лучше почитайте «Нож».', 'knife-customs'),
        ];

        // add user form fields
        wp_localize_script('knife-custom-' . $slug, 'knife_custom_wizard', $options);
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
