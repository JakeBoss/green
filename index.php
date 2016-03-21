<?php
/**
 * The main template file.
 * This is the most generic template file in a WordPress theme
 * It is used to display a page when nothing more specific matches a query.
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package mpress
 */
?>

<?php get_header(); ?>

<div id="primary" class="content-area row">
    <main id="main" class="site-main column sm-8" role="main">
        <?php if ( have_posts() ) : ?>

            <?php if ( is_home() && !is_front_page() ) : ?>
                <header>
                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( sprintf( 'template-parts/%s', get_theme_mod( 'mpress_archive_type', 'content' ) ), get_post_format() ); ?>
            <?php endwhile; ?>

            <?php the_posts_navigation(); ?>
        <?php else : ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; ?>
    </main><!-- #main -->
    <aside id="sidebar" class="column sm-4">
        <?php get_sidebar(); ?>
    </aside>
</div><!-- #primary -->
<?php get_footer(); ?>
