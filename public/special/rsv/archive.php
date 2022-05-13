<?php
/**
 * special archive template
 */

get_header(); ?>

<div class="caption">
    <div class="caption__description">
        <?php
            printf(
                '<h1>%s</h1>',
                _x('<strong>Совместный проект</strong> платформы «Россия — страна возможностей» и журнала «Нож»', 'special: rsv', 'knife-customs')
            );

            printf(
                '<img src="%s" alt="">',
                plugin_dir_url(__FILE__) . 'images/logo.png'
            );
        ?>
    </div>
</div>

<div class="archive">
    <?php
        while(have_posts()) : the_post();

            include plugin_dir_path(__FILE__) . 'loop.php';

        endwhile;
    ?>
</div>

<?php get_footer();
