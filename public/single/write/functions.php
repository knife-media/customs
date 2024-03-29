<?php
/**
 * write: custom functions
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

    // Let's add scripts
    wp_enqueue_script('knife-custom-' . $slug, $scripts, ['knife-theme'], $version, true);

    $fields = [
        'name' => [
            'element' => 'input',
            'type' => 'text',
            'required' => '',
            'autocomplete' => 'name',
            'maxlength' => 50,
            'placeholder' => __('Ваше имя, род занятий и проекты', 'knife-customs'),
        ],

        'email' => [
            'element' => 'input',
            'type' => 'email',
            'required' => '',
            'autocomplete' => 'email',
            'maxlength' => 50,
            'placeholder' => __('Электронная почта', 'knife-customs')
        ],

        'subject' => [
            'element' => 'input',
            'type' => 'text',
            'required' => '',
            'maxlength' => 100,
            'placeholder' => __('О чем хотите писать', 'knife-customs')
        ],

        'text' => [
            'element' => 'textarea',
            'required' => '',
            'placeholder' => __('Текст поста целиком без форматирования', 'knife-customs')
        ]
    ];

    // Get current time stamp
    $timestamp = time();

    $options = [
        'ajaxurl' => '/requests',
        'nonce' => substr(sha1($secret . $timestamp), -12, 10),
        'time' => $timestamp,
        'warning' => __('Не удалось отправить заявку. Попробуйте еще раз', 'knife-customs'),
        'button' => __('Отправить', 'knife-customs'),
        'heading' => __('Отправить заявку', 'knife-customs'),
        'fields' => $fields
    ];

    // add user form fields
    wp_localize_script('knife-custom-' . $slug, 'knife_custom_write', $options);
});
