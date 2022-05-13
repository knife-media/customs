<?php
/**
 * lighthouse: single template
 */

get_header(); ?>

<div class="content">
    <?php while(have_posts()) : the_post(); ?>

        <div class="caption">
            <div class="caption__description">
                <?php
                    printf(
                        '<img src="%s" alt="">',
                        plugin_dir_url(__FILE__) . 'images/logo.png'
                    );

                    printf(
                        '<a href="%s">%s</a>',
                        get_term_link('lighthouse', 'special'),
                        _x('Дом с маяком', 'special: lighthouse', 'knife-custom')
                    );
                ?>
            </div>
        </div>

        <article <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
            <div class="entry-header">
                <?php
                    printf(
                        '<p class="entry-header__emoji">%s</p>',
                        get_post_meta(get_the_ID(), 'post-emoji', true)
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

        <nav class="navigate">
            <?php
                previous_post_link('%link', '%title', true, '', 'special');
                next_post_link('%link', '%title', true, '', 'special');
            ?>
        </nav>

    <?php endwhile; ?>
</div>

<?php include plugin_dir_path(__FILE__) . 'footer.php';
