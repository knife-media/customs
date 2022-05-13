<?php
/**
 * profi: archive template
 */

get_header(); ?>

<div class="archive">
    <div class="archive__caption">
        <?php
            $slug = basename(__DIR__);

            printf(
                '<img src="%s" alt="">',
                content_url("customs/special/{$slug}/images/logo.png")
            );

            printf(
                '<h1>%s</h1>',
                _x('<strong>Совместный проект</strong> платформы олимпиады «Я — профессионал» и журнала «Нож»', 'special: profi', 'knife-theme')
            );
        ?>
    </div>

    <?php
        while(have_posts()) : the_post();

            include __DIR__ . '/loop.php';

        endwhile;
    ?>
</div>

<?php get_footer();
