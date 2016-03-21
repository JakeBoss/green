<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package mpress
 */
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="site-info wrapper">
        <a href="<?php echo esc_url( __( 'https://midwestfamilymarketing.com', 'mpress' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'mpress' ), 'mpress' ); ?></a>
        <?php printf( esc_html__( '%1$s by %2$s.', 'mpress' ), 'A Wordpress Based CMS', '<a href="http://midwestdigitalmarketing.com" rel="designer">Mid-West Family Marketing</a>' ); ?>
    </div><!-- .site-info -->
</footer><!-- #colophon -->

</div><!-- #page -->

<?php if( get_theme_mod( 'mpress_mobile_menu', 'simple' ) == 'menu-off-canvas' ) { echo '</div>'; } ?>

<?php wp_footer(); ?>
<img id="makers-mark" src="<?php echo get_template_directory_uri(); ?>/images/makers-mark.svg">
</body>
</html>
