<?php
/**
 * The template for displaying archive pages.
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package mpress
 */
?>
<?php get_header(); ?>

<div id="primary" class="content-area row">
    <main id="main" class="site-main column sm-8" role="main">
        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
            </header><!-- .page-header -->

            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'template-parts/content', get_post_format() ); ?>
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
