<?php
/**
 * feedback: custom functions
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Add custom styles
 */
add_action('wp_enqueue_scripts', function() {
    $version = '1.2';

    // Get page slug
    $slug = basename(__DIR__);

    // Get styles
    $styles = content_url("customs/single/{$slug}/styles.min.css");

    // Get scripts
    $scripts = content_url("customs/single/{$slug}/scripts.min.js");

    if(defined('WP_DEBUG') && true === WP_DEBUG) {
        $version = date('U');
    }

    if(!defined('KNIFE_REQUESTS')) {
        define('KNIFE_REQUESTS', []);
    }

    // Get secret from config
    $secret = empty(KNIFE_REQUESTS['secret']) ? '' : KNIFE_REQUESTS['secret'];

    // Let's add styles
    wp_enqueue_style('knife-custom-' . $slug, $styles, ['knife-theme'], $version);

    // Let's add scripts
    wp_enqueue_script('knife-custom-' . $slug, $scripts, ['knife-theme'], $version, true);

    $formats = [
        'custom' => __('Спецпроект с кастомным дизайном', 'knife-customs'),
        'levels' => __('Уровни', 'knife-customs'),
        'cards' => __('Карточки', 'knife-customs'),
        'quiz' => __('Тест', 'knife-customs'),
        'special' => __('Хаб на сайте «Ножа»', 'knife-customs'),
        'longread' => __('Лонгрид', 'knife-customs'),
        'news' => __('Новость', 'knife-customs'),
        'generator' => __('Генератор', 'knife-customs'),
        'flipper' => __('Перевертыши', 'knife-customs'),
        'social-knife' => __('Публикация в соцсетях', 'knife-customs'),
        'social-client' => __('Посты в соцсетях клиента', 'knife-customs')
    ];

    $brief = [
        'company' => __('Как называется ваша компания?', 'knife-customs'),
        'site' => __('Сайт компании или продукта', 'knife-customs'),
        'what' => __('Что вы хотите прорекламировать?', 'knife-customs'),
        'purpose' => __('Какова цель рекламной кампании?', 'knife-customs'),
        'users' => __('Кто ваша целевая аудитория?', 'knife-customs'),
        'budget' => __('Какой у вас бюджет?', 'knife-customs'),
        'similar' => __('Какие спецпроекты вам нравятся?', 'knife-customs'),
        'time' => __('Когда планируется рекламная кампания?', 'knife-customs'),
        'name' => __('Как вас зовут?', 'knife-customs'),
        'contacts' => __('Номер телефона и/или аккаунт в телеграме', 'knife-customs'),
        'email' => __('Адрес электронной почты', 'knife-customs')
    ];

    $callback = [
        'email' => __('Ваша почта', 'knife-customs'),
        'button' => __('Хочу с вами сотрудничать', 'knife-customs'),
    ];

    // Get current time stamp
    $timestamp = time();

    $privacy = sprintf(
        __('Отправляя данную форму, вы соглашаетесь с <a href="%s" target="_blank">пользовательским соглашением</a> и даёте своё согласие на обработку <a href="%s" target="_blank">персональных данных</a>.', 'knife-customs'),
        get_permalink(get_page_by_path('user-agreement')),
        get_permalink(get_page_by_path('privacy'))
    );

    $options = [
        'ajaxurl' => '/requests',
        'nonce' => substr(sha1($secret . $timestamp), -12, 10),
        'time' => $timestamp,
        'button' => __('Отправить', 'knife-customs'),
        'success' => __('Сообщение отправлено', 'knife-customs'),
        'error' => __('Ошибка. Попробуйте позже', 'knife-customs'),
        'privacy' => $privacy,
        'figure' => compact('formats', 'brief', 'callback')
    ];

    // add user form fields
    wp_localize_script('knife-custom-' . $slug, 'knife_custom_feedback', $options);
});
