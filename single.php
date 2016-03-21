<?php
/**
 * The template for displaying all single posts.
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @package mpress
 */
?>

<?php get_header(); ?>

<div id="primary" class="content-area clearfix">

    <main id="main" class="site-main column sm-8" role="main">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content', 'single' ); ?>
            <?php the_post_navigation(); ?>
            <?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
        <?php endwhile; // End of the loop. ?>
    </main><!-- #main -->

    <aside id="sidebar" class="column sm-4">
        <?php get_sidebar(); ?>
    </aside>

</div><!-- #primary -->

<?php get_footer(); ?>
