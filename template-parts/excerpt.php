<?php
/**
 * Template part for displaying post excerpts
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package mpress
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <div class="entry-thumbnail">
            <?php if( has_post_thumbnail( ) ) {
                    the_post_thumbnail();
                } else {
                    mpress_featured_image();
                } ?>
        </div>
        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

        <?php if ( get_post_type() == 'post' ) : ?>
            <div class="entry-meta">
                <?php mpress_entry_meta( ); ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_excerpt(); ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php mpress_entry_meta( array( 'edit' => true ), false ); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->