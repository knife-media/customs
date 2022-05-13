<?php
/**
 * special archive template
 */

get_header(); ?>

<div class="content">

    <div class="caption">
        <div class="caption__description">
            <?php
                $slug = basename(__DIR__);

                printf(
                    '<h1>%s</h1>',
                    _x('Это бизнес.<br> И это личное', 'special: new-business', 'knife-customs')
                );

                printf(
                    '<img src="%s" alt="">',
                    content_url("customs/special/{$slug}/images/spinner.png")
                );
            ?>
        </div>
    </div>

    <div class="archive">
        <?php
            while(have_posts()) : the_post();

                include __DIR__ . '/loop.php';

            endwhile;
        ?>
    </div>
</div>

<?php get_footer();
