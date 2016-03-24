<?php
/**
 * Template part for displaying page content in page.php.
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package mpress
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<<<<<<< HEAD
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->
=======

>>>>>>> 55a4cfbaa05dd3e246828f3c78e34e4f546e762c

    <div class="entry-content">
        <?php the_content(); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mpress' ), 'after'  => '</div>',) ); ?>
    </div><!-- .entry-content -->

<<<<<<< HEAD
    <footer class="entry-footer">
        <?php mpress_entry_meta( array( 'edit' => true ), false ); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->

=======
</article><!-- #post-## -->
>>>>>>> 55a4cfbaa05dd3e246828f3c78e34e4f546e762c
