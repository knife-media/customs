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
                    _x('Путешествовать с инвалидностью можно. Кто в России делает туризм доступным', 'special: tourism-for-all', 'knife-customs')
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
