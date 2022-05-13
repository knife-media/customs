<?php
/**
 * special archive template
 */

get_header(); ?>

<div class="content">

    <div class="caption">
        <div class="caption__description">
            <?php
                printf(
                    '<h1>%s</h1>',
                    _x('Это бизнес.<br> И это личное', 'special: new-business', 'knife-customs')
                );

                printf(
                    '<img src="%s" alt="">',
                    plugin_dir_url(__FILE__) . 'images/spinner.png'
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
</div>

<?php get_footer();
