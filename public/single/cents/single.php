<?php
/**
 * cents: single template
 */
get_header(); ?>

<section class="content">

    <?php while(have_posts()) : the_post(); ?>

        <article <?php post_class('post post--cents'); ?> id="post-<?php the_ID(); ?>">
            <div class="entry-cents">
                <?php
                    the_title(
                        '<h1 class="entry-cents__title">',
                        '</h1>'
                    );

                    the_lead(
                        '<div class="entry-cents__lead">',
                        '</div>'
                    );
                ?>
            </div>

            <div class="entry-cents">
                <?php
                    the_content();
                ?>
            </div>
        </article>

    <?php endwhile; ?>

</section>

<?php get_footer();
