<?php
/**
 * The Author template file
 * Used to display author information + archives
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @see http://codex.wordpress.org/Author_Templates
 * @package mpress
 */
?>

<?php get_header(); ?>

<div id="primary" class="content-area row">
    <main id="main" class="site-main column sm-8" role="main">

        <?php $curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) ); ?>

        <header>
            <h1><?php echo $curauth->display_name; ?></h1>
        </header>
        <div class="author-content">
            <p><?php echo wpautop( $curauth->description); ?></p>
        </div>

        <hr>
    <!-- The Loop -->
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php// get_template_part( 'template-parts/content', get_post_format() ); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'author-archive' ); ?>>
                <header class="entry-header">
                    <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                    <?php if ( 'post' === get_post_type() ) : ?>
                    <div class="entry-meta">
                        <?php mpress_entry_meta(); ?>
                    </div><!-- .entry-meta -->
                    <?php endif; ?>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php
                        the_content( sprintf(
                            /* translators: %s: Name of current post. */
                            wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'mpress' ), array( 'span' => array( 'class' => array() ) ) ),
                            the_title( '<span class="screen-reader-text">"', '"</span>', false )
                        ) );
                    ?>

                    <?php
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mpress' ),
                            'after'  => '</div>',
                        ) );
                    ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php mpress_entry_footer(); ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-## -->
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