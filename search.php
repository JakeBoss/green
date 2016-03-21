lor <?php
/**
 * The template for displaying search results pages.
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 * @package mpress
 */
?>

<?php get_header(); ?>
    <div id="primary" class="content-area row">
        <main id="main" class="site-main column sm-8" role="main">
        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'mpress' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </header>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'template-parts/content', 'search' ); ?>
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
