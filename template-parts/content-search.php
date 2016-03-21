<?php
/**
 * Template part for displaying results in search pages.
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package mpress
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <!-- Conditionally style how posts, pages, or other post types are displayed -->
        <?php if ( get_post_type() == 'post' ) : ?>
            <div class="entry-meta">
                <?php mpress_entry_meta(); ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->

    <footer class="entry-footer">
        <?php mpress_entry_meta( array( 'edit' => true ), false ); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->

