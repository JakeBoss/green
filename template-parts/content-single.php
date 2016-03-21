<?php
/**
 * Template part for displaying single posts.
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package mpress
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting">
    <meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>"/>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' ); ?>
        <div class="entry-meta">
            <?php mpress_entry_meta( ); ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->
    <div class="entry-content" itemprop="text articleBody">
        <?php the_content(); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mpress' ), 'after'  => '</div>',) ); ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php mpress_entry_meta( array( 'edit' => true ), false ); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->

