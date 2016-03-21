<?php
/**
 * Template part for displaying posts.
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package mpress
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <?php if ( get_post_type() == 'post' ) : ?>
            <div class="entry-meta">
                <?php mpress_entry_meta( ); ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->
    <div class="entry-content">
        <?php the_content(); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mpress' ), 'after'  => '</div>',) ); ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php mpress_entry_meta( array( 'edit' => true ), false ); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
