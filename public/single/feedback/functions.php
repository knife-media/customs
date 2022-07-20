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
        'custom' => __('Спецпроект с кастомным дизайном', 'knife-theme'),
        'levels' => __('Уровни', 'knife-theme'),
        'cards' => __('Карточки', 'knife-theme'),
        'quiz' => __('Тест', 'knife-theme'),
        'special' => __('Хаб на сайте «Ножа»', 'knife-theme'),
        'longread' => __('Лонгрид', 'knife-theme'),
        'news' => __('Новость', 'knife-theme'),
        'generator' => __('Генератор', 'knife-theme'),
        'flipper' => __('Перевертыши', 'knife-theme'),
        'social-knife' => __('Публикация в соцсетях', 'knife-theme'),
        'social-client' => __('Посты в соцсетях клиента', 'knife-theme')
    ];

    $brief = [
        'company' => __('Как называется ваша компания?', 'knife-theme'),
        'site' => __('Сайт компании или продукта', 'knife-theme'),
        'what' => __('Что вы хотите прорекламировать?', 'knife-theme'),
        'purpose' => __('Какова цель рекламной кампании?', 'knife-theme'),
        'users' => __('Кто ваша целевая аудитория?', 'knife-theme'),
        'budget' => __('Какой у вас бюджет?', 'knife-theme'),
        'similar' => __('Какие спецпроекты вам нравятся?', 'knife-theme'),
        'time' => __('Когда планируется рекламная кампания?', 'knife-theme'),
        'name' => __('Как вас зовут?', 'knife-theme'),
        'contacts' => __('Номер телефона и/или аккаунт в телеграме', 'knife-theme')
    ];

    $callback = [
        'email' => __('Ваша почта', 'knife-theme'),
        'button' => __('Хочу с вами сотрудничать', 'knife-theme'),
    ];

    // Get current time stamp
    $timestamp = time();

    $privacy = sprintf(
        __('Отправляя данную форму, вы соглашаетесь с <a href="%s" target="_blank">пользовательским соглашением</a> и даёте своё согласие на обработку <a href="%s" target="_blank">персональных данных</a>.', 'knife-theme'),
        get_permalink(get_page_by_path('user-agreement')),
        get_permalink(get_page_by_path('privacy'))
    );

    $options = [
        'ajaxurl' => '/requests',
        'nonce' => substr(sha1($secret . $timestamp), -12, 10),
        'time' => $timestamp,
        'button' => __('Отправить', 'knife-theme'),
        'success' => __('Сообщение отправлено', 'knife-theme'),
        'error' => __('Ошибка. Попробуйте позже', 'knife-theme'),
        'privacy' => $privacy,
        'figure' => compact('formats', 'brief', 'callback')
    ];

    // add user form fields
    wp_localize_script('knife-custom-' . $slug, 'knife_theme_custom', $options);
});
