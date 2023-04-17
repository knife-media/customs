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
        if (!is_front_page()) {
            return;
        }

        $version = '2.4';

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
                    __('Вы попали на секретную страницу, где можно задать вопрос оракулу «Ножа». Сосредоточьтесь и подумайте о ситуации, которая вам неясна, вспомните свои желания и сформулируйте запрос. Оракул выдаст предсказание о ближайших перспективах для вас или персоны, на которую вы гадаете.', 'knife-customs'),
                    __('Когда почувствуете, что готовы, нажимайте на кнопку.', 'knife-customs'),
                ],
                'button' => __('Узнать', 'knife-customs'),
                'labels' => [
                    __('про мох в волшебном лесу', 'knife-customs'),
                    __('что прячет в дупле ваша белочка', 'knife-customs'),
                    __('о чем кряхтит свиристель', 'knife-customs'),
                    __('что скрывают пузыри в болоте', 'knife-customs'),
                    __('на кого точит клык кикимора', 'knife-customs'),
                    __('когда небо встретится с землей', 'knife-customs'),
                    __('зачем рептилоиды создали симуляцию', 'knife-customs'),
                    __('кто сидел у вас под кроватью', 'knife-customs'),
                ]
            ],
            'selection' => [
                'title' => __('Выберите 4 символа', 'knife-customs'),
                'label' => __('нажимайте интуитивно, не задумываясь', 'knife-customs'),
                'button' => __('Вперед', 'knife-customs'),
            ],
            'error' => [
                'title' => __('Не получилось', 'knife-customs'),
                'text'  => __('Сегодня оракул не может вам ответить. Попробуйте еще раз или приходите завтра.', 'knife-customs'),
            ],
            'repeated' => __('Не испытывайте судьбу дважды. Задайте следующий вопрос оракулу позже, а пока воспользуйтесь гаданием на текстах. Нажмите на кубики игральных костей справа от меню — откроется статья, внутри которой скрывается знак для вас.', 'knife-customs'),
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
