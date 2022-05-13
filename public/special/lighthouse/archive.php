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
                    content_url("customs/special/{$slug}/images/logo.png")
                );

                printf(
                    '<h1>%s</h1>',
                    _x('Дом с маяком', 'special: lighthouse', 'knife-custom')
                );

                printf(
                    '<p>%s</p>',
                    _x(
                        'Истории пациентов, их семей и ассистентов хосписа «Дом с маяком»',
                        'special: lighthouse', 'knife-custom'
                    )
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

<?php include __DIR__ . '/footer.php';
