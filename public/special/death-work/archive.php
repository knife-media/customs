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
                    '<img src="%s" alt="">',
                    content_url("customs/special/{$slug}/images/logo-white.svg")
                );

                printf(
                    '<h1>%s</h1>',
                    _x('Как работать с трупами и не сойти с ума', 'special: death-work', 'knife-customs')
                );

                printf(
                    '<p>%s</p>',
                    _x('Истории людей непростых профессий', 'special: death-work', 'knife-customs')
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
