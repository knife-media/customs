<?php
/**
 * misis: archive template
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
                    _x('Специальный проект Национального исследовательского технологического университета «МИСиС» и журнала «Нож»', 'special: misis', 'knife-customs')
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

<?php if(have_posts()) : ?>
    <nav class="navigate">
        <?php
            previous_posts_link(__('Предыдущие', 'knife-custom'));
            next_posts_link(__('Следующие', 'knife-custom'));
        ?>
    </nav>
<?php endif; ?>

<?php get_footer();
