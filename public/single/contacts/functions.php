<?php
/**
 * contacts: custom functions
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Add custom assets
 */
add_action('wp_enqueue_scripts', function() {
    $version = '1.0';

    // Get page slug
    $slug = basename(__DIR__);

    // Get styles
    $styles = content_url("customs/single/{$slug}/styles.min.css");

    // Get scripts
    $scripts = content_url("customs/single/{$slug}/scripts.min.js");

    if(defined('WP_DEBUG') && true === WP_DEBUG) {
        $version = date('U');
    }

    // Let's add styles
    wp_enqueue_style('knife-custom-' . $slug, $styles, ['knife-theme'], $version);

    // Let's add scripts
    wp_enqueue_script('knife-custom-' . $slug, $scripts, ['knife-theme'], $version, true);

    $fields = [
        [
            'case' => __('Я — читатель, хочу прислать сердечко, указать на проблему или поспорить с автором материала', 'knife-theme'),
            'more' => __('Отлично, а чего именно вы хотите прямо сейчас?', 'knife-theme'),
            'options' => [
                [
                    'case' => __('Вижу опечатку и хочу, чтобы ее исправили', 'knife-theme'),
                    'answer' => __('Нет ничего проще: выделите опечатку и нажмите Сtrl+Enter.', 'knife-theme'),
                ],

                [
                    'case' => __('Вижу серьезную фактическую ошибку, и проверка показывает, что правда на моей стороне', 'knife-theme'),
                    'answer' => __('Какой ужас! Напишите, пожалуйста, на <a href="mailto:editor@knife.media">editor@knife.media</a> письмо с темой «Фактическая ошибка», и мы во всем разберемся.', 'knife-theme'),
                ],

                [
                    'case' => __('У меня не грузится / криво отображается сайт «Ножа»', 'knife-theme'),
                    'answer' => __('Отвратительно, как мы могли это допустить? Напишите, пожалуйста, на <a href="mailto:admin@knife.media">admin@knife.media</a> письмо с темой «Глюк», приложите скриншот с ошибкой и расскажите, какая у вас операционная система, браузер и регион. Мы благодарны всем, кто помогает делать наш сайт лучше.', 'knife-theme'),
                ],

                [
                    'case' => __('Меня триггерит ваша статья!', 'knife-theme'),
                    'answer' => __('Сообщите об этом в комментарии к ней. Авторы читают комменты под своими материалами — заставьте человека задуматься о том, что он может быть неправ. Только аргументированно, без оскорблений и перехода на личности. Хамов мы баним.', 'knife-theme'),
                ],

                [
                    'case' => __('Ваша статья заставила меня задуматься, хочу написать свою — поспорить, показать тему с другой стороны', 'knife-theme'),
                    'answer' => __('Очень хорошо, напишите ее и пришлите через <a href="https://knife.media/write/" target="_blank">форму</a> нашего Клуба.', 'knife-theme'),
                ],

                [
                    'case' => __('Вижу плагиат, нарушение копирайта', 'knife-theme'),
                    'answer' => __('Не может быть! Напишите, пожалуйста, об этом на <a href="mailto:editor@knife.media">editor@knife.media</a>, и мы во всем разберемся.', 'knife-theme'),
                ],
            ],
        ],

        [
            'case' => __('Я — автор, хочу писать для вас', 'knife-theme'),
            'more' => __('Здорово, а о чем вы хотите нам писать? Кстати, обязательно прочитайте наш <a href="https://knife.media/knife-bible/" target="_blank">гид для авторов</a>, прежде чем предлагать свои тексты.', 'knife-theme'),
            'options' => [
                [
                    'case' => __('Я могу обо всем — наука, культура, политика, история, экология, интервью', 'knife-theme'),
                    'answer' => __('Наш опыт показывает, что невозможно получить качественный материал от человека, который считает, что одинаково хорошо разбирается в множестве различных тем. Определитесь со сферами вашего интереса, наработайте компетенции в них и приходите снова.', 'knife-theme'),

                ],

                [
                    'case' => __('Пишу про людей — классные социальные проекты, интересный личный опыт, психологические феномены, благотворительность, а еще о погружении в различные культуры во время путешествий', 'knife-theme'),
                    'answer' => __('Пришлите на <a href="mailto:artem@knife.media">artem@knife.media</a> письмо с темой «Автор о [том-то]» с коротким рассказом о своих компетенциях. Приложите ссылки на 3 ваших лучших материала (посты в соцсетях не считаются) и предложите 3-5 тем, которыми бы готовы заняться в ближайший месяц.', 'knife-theme'),

                ],

                [
                    'case' => __('Моя тематика есть среди этих: образование, экология, осознанное потребление, влияние цифровых технологий на общество, философия познания, нейронауки', 'knife-theme'),
                    'answer' => __('Пришлите на <a href="mailto:travkina@knife.media">travkina@knife.media</a> письмо с темой «Автор о [том-то]» с коротким рассказом о своих компетенциях. Приложите ссылки на 3 ваших лучших материала (посты в соцсетях не считаются) и предложите 3-5 тем, которыми бы готовы заняться в ближайший месяц.', 'knife-theme'),

                ],

                [
                    'case' => __('Я больше про естественные науки / гуманитарный академический дискурс / вопросы гендера, феминизма, равноправия / искусство и философию', 'knife-theme'),
                    'answer' => __('Пришлите на <a href="mailto:science@knife.media">science@knife.media</a> письмо с темой «Автор о [том-то]» с коротким рассказом о своих компетенциях. Приложите ссылки на 3 ваших лучших материала (посты в соцсетях не считаются) и предложите 3-5 тем, которыми бы готовы заняться в ближайший месяц.', 'knife-theme'),

                ],

                [
                    'case' => __('Я пишу на одну из следующих тем: литература, российский андеграунд, всевозможная дичь в кино, интернете и культуре вообще', 'knife-theme'),
                    'answer' => __('Пришлите на <a href="mailto:hr@knife.media">hr@knife.media</a> письмо с темой «Автор о [том-то]» с коротким рассказом о своих идеях и потенциальных героях. Приложите ссылки на 3 ваших лучших материала (посты в соцсетях не считаются) и предложите тему.', 'knife-theme'),
                ],
            ]
        ],

        [
            'case' => __('Я — пиар-специалист, есть идея по сотрудничеству', 'knife-theme'),
            'more' => __('Надеемся, вы классный пиар-специалист (классные пиар-специалисты изучают площадку и приходят с эксклюзивными идеями, релевантными ее тематикам и формату, не классные — бомбят массовыми рассылками корявых пресс-релизов на малоинтересные темы). В любом случае, как спрашивают в шпионских фильмах, на кого вы работаете?', 'knife-theme'),
            'options' => [
                [
                    'case' => __('На коммерческий бренд, на агентство, которое представляет такой бренд, или благотворительную инициативу бренда', 'knife-theme'),
                    'answer' => __('Если у вас есть бюджет или выдающееся в своей щедрости предложение бартера, напишите нам на <a href="mailto:pr@knife.media">pr@knife.media</a>. Если нет, то давайте подождем, пока они появятся. Мы считаем честным зарабатывать на тех, кто прямо зарабатывает на наших читателях или тратит их внимание на новость, повышающую осведомленность и лояльность к бренду и служащую непрямым инструментом увеличения продаж.', 'knife-theme'),
                ],

                [
                    'case' => __('На человека, который хочет повысить личную медийность', 'knife-theme'),
                    'answer' => __('Есть два пути: сложный и простой. Сложный состоит в том, чтобы человек ознакомился с контентом нашего сайта, прочел <a href="https://knife.media/write/" target="_blank">правила Клуба</a> и прислал через форму готовую статью, интересную нашим читателям. Простой — <a href="https://knife.media/advertising/" target="_blank">вот здесь</a>.', 'knife-theme'),
                ],

                [
                    'case' => __('На НКО, волонтерский фонд или другие благотворительные проекты, не связанные с брендами', 'knife-theme'),
                    'answer' => __('Благотворительных инициатив очень много, и чтобы не давить на читателя валом контента, требующего от него сопереживания и денег, мы не размещаем фандрайзинговые новости, рапорты об успехах фондов и справки о тяжести ситуации с Х в России. Вместо этого мы просим подготовить материалы, которые апеллируют к интересам обычного читателя — показываем, что люди с серьезными нарушениями здоровья умеют в <a href="https://knife.media/anastasia-ponyatskaya/" target="_blank">самоиронию</a>, в хосписах бывают <a href="https://knife.media/federmesser/" target="_blank">свидания</a>, а привозить подарки сиротам — <a href="https://knife.media/presents-for-orphans/">вредно</a>. Если вы можете подготовить материал такого уровня, присылайте на <a href="mailto:artem@knife.media">artem@knife.media</a> свои идеи. Мы ответим, если они нас заинтересуют.', 'knife-theme'),
                ],

                [
                    'case' => __('На культурную, научную или иную просветительскую инициативу, не требующую от читателя платы за ознакомление и участие', 'knife-theme'),
                    'answer' => __('Если ваша инициатива бесплатна для пользователя, не связана ни с какими коммерческими или политическими организациями и релевантна аудитории «Ножа» по тематике, вы можете предложить анонс на <a href="mailto:news@knife.media">news@knife.media</a>. В остальных случаях ответ вас ждет <a href="https://knife.media/advertising/" target="_blank">вот здесь</a>.', 'knife-theme'),
                ],
            ],
        ],
    ];

    $options = [
        'start' => __('Давайте!', 'knife-theme'),
        'retry' => __('Пройти заново', 'knife-theme'),
        'heading' => __('Давайте знакомиться — к какой категории вы себя относите?', 'knife-theme'),
        'fields' => $fields,
    ];

    wp_localize_script('knife-custom-' . $slug, 'knife_theme_custom', $options);
});
