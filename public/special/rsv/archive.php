<?php
/**
 * special archive template
 */

get_header(); ?>

<div class="caption">
    <div class="caption__description">
        <?php
            $slug = basename(__DIR__);

            printf(
                '<h1>%s</h1>',
                _x('<strong>Совместный проект</strong> платформы «Россия — страна возможностей» и журнала «Нож»', 'special: rsv', 'knife-customs')
            );

            printf(
                '<img src="%s" alt="">',
                content_url("customs/special/{$slug}/images/rsv-logo.png")
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

<?php get_footer();
