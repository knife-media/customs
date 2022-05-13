<?php
/**
 * archive template
 *
 * @package knife-theme
 * @since 1.15
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

                echo term_description();
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
