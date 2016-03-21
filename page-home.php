<?php
/**
 * Template Name: Home Page Template
 * This is the Home page template.
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package mpress
 */
?>
<?php get_header(); ?>
hey look at this
    <div id="primary" class="content-area row">
        <main id="main" class="site-main column sm-8" role="main">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'template-parts/content', 'page' ); ?>
                <?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
            <?php endwhile; // End of the loop. ?>
        </main><!-- #main -->
        <aside id="sidebar" class="column sm-4">
            <?php get_sidebar(); ?>
        </aside>
    </div><!-- #primary -->
<?php get_footer(); ?>
