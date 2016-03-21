<?php
/**
 * The template for displaying 404 pages (not found).
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @package mpress
 */
?>

<?php get_header(); ?>

<div id="primary" class="content-area clearfix">

    <main id="main" class="site-main column sm-8" role="main">

        <section class="error-404 not-found">

            <header class="page-header">
                <p class="warning-404"><?php esc_html_e( '404', 'mpress' ); ?></p>
                <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'mpress' ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'mpress' ); ?></p>
                <?php get_search_form(); ?>
            </div>

        </section>

    </main>

    <aside id="sidebar" class="column sm-4">
        <?php get_sidebar(); ?>
    </aside>

</div>
<?php get_footer(); ?>
