<?php
/**
 * profi: archive template
 */

get_header(); ?>

<div class="archive">
    <div class="archive__caption">
        <?php
            printf(
                '<img src="%s" alt="">',
                plugin_dir_url(__FILE__) . 'images/logo.png'
            );

            printf(
                '<h1>%s</h1>',
                _x('<strong>Совместный проект</strong> платформы олимпиады «Я — профессионал» и журнала «Нож»', 'special: profi', 'knife-theme')
            );
        ?>
    </div>

    <?php
        while(have_posts()) : the_post();

            include plugin_dir_path(__FILE__) . 'loop.php';

        endwhile;
    ?>
</div>

<?php get_footer();
