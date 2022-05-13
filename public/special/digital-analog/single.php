<?php
/**
 * digital-analog: single template
 */

get_header(); ?>

<div class="content">
    <?php while(have_posts()) : the_post(); ?>

        <div class="caption">
            <?php
                $term = get_term_by('slug', 'digital-analog', 'special');

                printf(
                    '<div class="caption__title"><a href="%s">%s</a></div>',
                    get_term_link($term->term_id),
                    esc_html($term->name)
                );

                printf(
                    '<div class="caption__description">%s</div>',
                    wpautop($term->description)
                );
            ?>
        </div>

        <article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
            <div class="entry-header">
                <?php
                    the_info(
                        '<div class="entry-header__info">', '</div>',
                        ['author']
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
                ?>
            </div>
        </article>

    <?php endwhile; ?>
</div>

<?php get_footer();
