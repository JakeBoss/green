<?php
/**
 * The header for our theme.
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package mpress
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]>  <html lang="en" class="no-js ie6">  <![endif]-->
<!--[if IE 7 ]>     <html lang="en" class="no-js ie7">  <![endif]-->
<!--[if IE 8 ]>     <html lang="en" class="no-js ie8">  <![endif]-->
<!--[if IE 9 ]>     <html lang="en" class="no-js ie9">  <![endif]-->
<!--[if IE 10 ]>    <html lang="en" class="no-js ie10"> <![endif]-->
<!--[if (gt IE 10)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
    <!-- define character set -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <!-- XFN Metadata Profile -->
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <!-- mobile specific metadeta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- specify IE rendering version -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <!-- Wordpress pingback url -->
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!-- Wordpress generated head area -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', MPRESS_THEME_NAME ); ?></a>

<?php if( get_theme_mod( 'mpress_mobile_menu', null ) == 'menu-off-canvas' ) : ?>
    <!-- Here, we conditionally output off-canvas menu -->
    <div id="off-canvas-page-wrapper">
    <?php get_template_part( 'template-parts/offcanvas' ); ?>
<?php endif; ?>
<div id="form-window">
    <div class="close-window">
        <button id="form-close" class="fa fa-close close-window-btn"></button>
    </div>
    <div class="window-content">
        <?php do_action('content_block', array( id=>407 ) ); ?>
    </div>
</div>
<div id="form-window-call">
    <div class="close-window">
        <button id="form-close" class="fa fa-close close-window-btn"></button>
    </div>
    <div class="window-content">
        <?php do_action('content_block', array( id=>428 ) ); ?>
    </div>
</div>
    <header id="masthead" role="banner">
        <div class="wrapper">
            <div class="site-branding" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                <?php
                    if( get_theme_mod( 'mpress_site_logo', null ) ) {
                        $logo        = sprintf( '<img src="%1$s" alt="%2$s" title="%3$s" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">', esc_url_raw( get_theme_mod( 'mpress_site_logo') ), get_bloginfo( 'name' ), get_bloginfo( 'description' ) );
                        $title_class = 'site-title has-logo';
                    } else {
                        $logo        = sprintf( '<span class="anchor-text">%s</span>', get_bloginfo( 'name' ) );
                        $title_class = 'site-title';
                    }
                    $title_type  = ( is_front_page() || is_home() ) ? 'h1' : 'h2';
                    // Finally, echo output
                    echo sprintf( '<%1$s class="%2$s"><a href="%3$s" rel="home" itemprop="url">%4$s</a></%1$s>', $title_type, $title_class,  esc_url( home_url( '/' ) ), $logo);
                    echo sprintf( '<meta itemprop="name" content="%s">', get_bloginfo( 'name' ) );
                ?>
            </div><!-- .site-branding -->

<<<<<<< HEAD
            <button class="menu-toggle" aria-expanded="false" data-targets='<?php echo get_mpress_menu_target(); ?>'><i class="fa fa-bars"></i><span class="screen-reader-text"><?php esc_html_e( 'Menu', MPRESS_THEME_NAME ); ?></span></button>
=======
            <!-- <button class="menu-toggle" aria-expanded="false" data-targets='<?php echo get_mpress_menu_target(); ?>'><i class="fa fa-bars"></i><span class="screen-reader-text"><?php esc_html_e( 'Menu', MPRESS_THEME_NAME ); ?></span></button> -->
>>>>>>> 55a4cfbaa05dd3e246828f3c78e34e4f546e762c

            <nav id="site-navigation" class="<?php echo sprintf( 'main-navigation-bar %s', get_theme_mod( 'mpress_mobile_menu', 'menu-simple' ) ); ?>" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-expanded="false">
                <?php if( has_nav_menu( 'primary-navbar' ) ) : ?>
                    <?php wp_nav_menu( array( 'theme_location' => 'primary-navbar', 'container' => '', 'walker' => new Append_Dropdown_Buttons() ) ); ?>
                <?php endif; ?>
            </nav><!-- #site-navigation -->

<<<<<<< HEAD
        </div>
    </header><!-- #masthead -->

    <div class="banner-bottom clearfix">
=======
            <div class="customer-center">
              <div class="login">
                <p><span class="customer">Customer Center</span><a href="https://www.lawngateway.com/GreenerGrass/Login" target="_blank" class="log-btn">login</a></p>
              </div>
            </div>

        </div>
    </header><!-- #masthead -->
    <div class="phone-button">
    <div class="wrap">
        <div class="phone">
          <a href="tel:7158320800" class="call-btn">(715) 832-0800</a>
        </div>
    </div>
    </div>

    <!-- <div class="banner-bottom clearfix">
>>>>>>> 55a4cfbaa05dd3e246828f3c78e34e4f546e762c
        <div class="wrapper">
                <div class="breadcrumbs_wrapper">
                    <?php do_action( 'mpress_breadcrumbs' ); ?>
                </div>

                <div class="search_wrapper">
                    <?php get_search_form(); ?>
                </div>

                <div class="social">
                    <?php mpress_social_links(); ?>
                </div>
        </div>
<<<<<<< HEAD
    </div>
=======
    </div> -->
>>>>>>> 55a4cfbaa05dd3e246828f3c78e34e4f546e762c

    <div id="page" class="hfeed site">
        <div id="content" class="site-content">
