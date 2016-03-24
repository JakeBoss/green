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
<<<<<<< HEAD
    <div class="site-info wrapper">
        <a href="<?php echo esc_url( __( 'https://midwestfamilymarketing.com', 'mpress' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'mpress' ), 'mpress' ); ?></a>
        <?php printf( esc_html__( '%1$s by %2$s.', 'mpress' ), 'A Wordpress Based CMS', '<a href="http://midwestdigitalmarketing.com" rel="designer">Mid-West Family Marketing</a>' ); ?>
    </div><!-- .site-info -->
=======
<div class="row">
<div class="wrap">
<div class="col md-4 center">
    <?php if ( is_active_sidebar( 'contact-1' ) ) : dynamic_sidebar( 'contact-1' ); endif; ?>
</div>
<div class="col md-4 center">
    <?php if ( is_active_sidebar( 'contact-2' ) ) : dynamic_sidebar( 'contact-2' ); endif; ?>
</div>
<div class="col md-4 center">
    <?php if ( is_active_sidebar( 'foot-info' ) ) : dynamic_sidebar( 'foot-info' ); endif; ?>
</div>
<div class="col base-12 copyright center">
    <p>Copyright &copy;2016 Greener Grass Systems, Inc</p>
</div>
</div>
</div>



>>>>>>> 55a4cfbaa05dd3e246828f3c78e34e4f546e762c
</footer><!-- #colophon -->

</div><!-- #page -->

<?php if( get_theme_mod( 'mpress_mobile_menu', 'simple' ) == 'menu-off-canvas' ) { echo '</div>'; } ?>

<?php wp_footer(); ?>
<img id="makers-mark" src="<?php echo get_template_directory_uri(); ?>/images/makers-mark.svg">
</body>
</html>
