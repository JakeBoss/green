<aside class="off-canvas-menu">
    <header>
        <button class="menu-toggle" aria-expanded="false" data-targets='<?php echo get_mpress_menu_target(); ?>'><i class="icon fa fa-times"></i><span class="display-text"><?php esc_html_e( 'Close', MPRESS_THEME_NAME ); ?></span></button>
    </header>
    <div class="search-form">
        <?php get_search_form( true ); ?>
    </div>
    <nav id="off-canvas-navigation" class="navigation-menu  mobile-menu" aria-expanded="false" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
        <?php
            // Check if off canvas menu location has a menu assigned, else use primary menu
            $location = ( has_nav_menu( 'off-canvas-nav' ) ) ? 'off-canvas-nav' : 'primary-navbar';
            // Call Menu Function
            if( has_nav_menu( $location ) ) {
                wp_nav_menu( array( 'theme_location' => $location, 'container' => '', 'walker' => new Append_Dropdown_Buttons() ) );
            }
        ?>
    </nav><!-- #site-navigation -->
</aside>