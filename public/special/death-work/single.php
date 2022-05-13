<?php
/**
 * special single template
 */

get_header(); ?>

<div class="content">
    <?php while(have_posts()) : the_post(); ?>

        <div class="caption">
            <div class="caption__description">
                <?php
                    printf(
                        '<a href="%s">%s</a>',
                        get_term_link('death-work', 'special'),
                        _x('Как работать с трупами и не сойти с ума', 'special: death-work', 'knife-customs')
                    );
                ?>
            </div>
        </div>

        <article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
            <div class="entry-header">
                <?php
                    $slug = basename(__DIR__);

                    printf(
                        '<div class="entry-header__image"><img src="%s" alt=""></div>',
                        content_url("customs/special/{$slug}/images/logo-black.svg")
                    );

                    the_title(
                        '<h1 class="entry-header__title">',
                        '</h1>'
                    );

                    the_lead(
                        '<div class="entry-header__lead">',
                        '</div>'
                    );

                    the_share(
                        '<div class="entry-header__share share">',
                        '</div>'
                    );
                ?>
            </div>

            <div class="entry-content">
                <?php
                    the_content();

                    the_info(
                        sprintf(
                            '<h5>%s', _x('Автор материала', 'special: death-work', 'knife-customs')
                        ),
                        '</h5>', ['author']
                    );
                ?>
            </div>
        </article>

        <nav class="navigate">
            <?php
                previous_post_link('%link', '%title', true, '', 'special');
                next_post_link('%link', '%title', true, '', 'special');
            ?>
        </nav>

    <?php endwhile; ?>
</div>

<?php get_footer();
