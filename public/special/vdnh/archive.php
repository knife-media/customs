<?php
/**
 * archive template
 *
 * @package knife-theme
 * @since 1.10
 * @version 1.13
 */

get_header(); ?>

<?php if(have_posts() && get_the_archive_title()) : ?>
    <div class="caption">
        <div class="caption__description">
            <?php
                printf(
                    '<img src="%s" alt="">',
                    plugin_dir_url(__FILE__) . 'images/logo.png'
                );

                printf(
                    '<h1>%s</h1>',
                    _x('Специальный проект ВДНХ и журнала «Нож»', 'special: vdnh', 'knife-customs')
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
            previous_posts_link(__('Предыдущие', 'knife-customs'));
            next_posts_link(__('Следующие', 'knife-customs'));
        ?>
    </nav>
<?php endif; ?>

<?php get_footer();
