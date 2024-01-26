<?php
/**
 * special archive template
 */

get_header(); ?>

<?php if(have_posts() && get_the_archive_title()) : ?>
    <div class="caption">
        <div class="caption__description">
            <?php
                $slug = basename(__DIR__);

                printf(
                    '<img src="%s" alt="">',
                    content_url("customs/special/{$slug}/images/logo.png")
                );

                printf(
                    '<h1>%s</h1>',
                    _x('Cпециальный проект журнала «Нож» и фонда «Волонтеры в помощь детям-сиротам»', 'special: otkazniki', 'knife-customs')
                );
            ?>
        </div>

        <div class="caption__button">
            <?php
                printf(
                    '<a class="button" href="https://otkazniki.ru/how-to-help/" target="_blank" rel="noopener">%s</a>',
                    _x('Как помочь', 'special: otkazniki', 'knife-customs')
                );
            ?>
        </div>
    </div>
<?php endif; ?>

<div class="archive">
   <?php
        if(have_posts()) :
            while(have_posts()) : the_post();

                get_template_part('partials/loop', 'units');

            endwhile;
        else :

            get_template_part('partials/message');

        endif;
    ?>
</div>

<?php get_footer();
