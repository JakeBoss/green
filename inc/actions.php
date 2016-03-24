<?php
/*******************************************************************************
 *                         ___        __  _
 *                        /   | _____/ /_(_)___  ____  _____
 *                       / /| |/ ___/ __/ / __ \/ __ \/ ___/
 *                      / ___ / /__/ /_/ / /_/ / / / (__  )
 *                     /_/  |_\___/\__/_/\____/_/ /_/____/
 *
 ******************************************************************************/
/**
 * Actions
 * Define Actions using the Wordpress Actions / Filters / Hooks Plugin API
 * @package mpress
 * @see     https://codex.wordpress.org/Plugin_API/Action_Reference
 * @since   version 1.0.0
 */

/**
 * I18n Language Support
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/I18n_for_WordPress_Developers
 * @see   https://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */
if ( !function_exists( 'mpress_I18n' ) ) {
    function mpress_I18n() {
        load_theme_textdomain( MPRESS_THEME_NAME, MPRESS_ROOT_DIR . 'i18n' );
    } // end mpress_I18n()
    add_action( 'after_setup_theme', 'mpress_I18n' );
} // endif
/* -------------------------------------------------------------------------- */

/**
 * Add Theme Support
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/Function_Reference/add_theme_support
 */
if ( !function_exists( 'mpress_add_theme_support' ) ) {
    function mpress_add_theme_support() {
        // Automatic Feed Links
        add_theme_support( 'automatic-feed-links' );
        // Let WordPress provide the title tag
        add_theme_support( 'title-tag' );
        // Post Formats
        add_theme_support( 'post-formats', array( 'aside', 'audio', 'video', 'chat', 'gallery', 'image', 'quote', 'status', 'link' ) );
        // HTML5 Support
        add_theme_support( 'html5', array(  'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
        // Post Thumbnails
        add_theme_support( 'post-thumbnails' );
        // Set up the WordPress core custom background feature.
        // add_theme_support( 'custom-background', apply_filters( 'mpress_custom_background_args', array( 'default-color' => 'ffffff', 'default-image' => '', ) ) );
        add_theme_support( 'custom-background', array(
            'default-color'          => '',
            'default-image'          => '',
            'default-repeat'         => '',
            'default-position-x'     => '',
            'default-attachment'     => '',
            'wp-head-callback'       => 'mpress_custom_background_cb',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '' ) );
    } // end mpress_add_theme_support
    add_action( 'after_setup_theme', 'mpress_add_theme_support' );
} // endif
/* -------------------------------------------------------------------------- */

function mpress_custom_background_cb( $args ) {
        $background = get_background_image();
        $color = get_background_color();
        if ( ! $background && ! $color )
            return;

        $style = $color ? "background-color: #$color;" : '';
        $body_style = $color ? "background-color: #$color;" : '';

        if ( $background ) {
            $image = " background-image: url('$background');";

            $repeat = get_theme_mod( 'background_repeat', 'repeat' );
            if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
                $repeat = 'repeat';
            $repeat = " background-repeat: $repeat;";

            $position = get_theme_mod( 'background_position_x', 'left' );
            if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
                $position = 'left';
            $position = " background-position: top $position;";

            $attachment = get_theme_mod( 'background_attachment', 'scroll' );
            if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
                $attachment = 'scroll';
            $attachment = " background-attachment: $attachment;";

            $style .= $image . $repeat . $position . $attachment;
        }
        include MPRESS_INC_DIR . 'partials/custom-background.php';
}

/**
 * Remove unnecessary junk from the head
 * @since version 1.0.0
 */
if ( !function_exists( 'mpress_clean_head' ) ) {
    function mpress_clean_head() {
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'index_rel_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
    } // end mpress_remove_head_links
    add_action('init', 'mpress_clean_head');
} // endif

/* -------------------------------------------------------------------------- */

/**
 * Enqueue Front-End Stylesheet(s)
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/Function_Reference/wp_enqueue_style
 */
if ( !function_exists( 'mpress_styles' ) ) {
    function mpress_styles() {
        // register styles
<<<<<<< HEAD
        wp_register_style( 'mpress-theme-fonts', '//fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic|Roboto+Mono:400,400italic|Droid+Serif:400,400italic,700,700italic', false, null );
=======
        wp_register_style( 'mpress-theme-fonts', '//fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic|Roboto+Mono:400,400italic|Droid+Serif:400,400italic,700,700italic|Open+Sans:400,800,700,600,300', false, null );
>>>>>>> 55a4cfbaa05dd3e246828f3c78e34e4f546e762c
        wp_register_style( 'mpress-theme-style', MPRESS_STYLES_URI . 'style.css', false, null);
        // Engueue Styles
        wp_enqueue_style( 'mpress-theme-fonts' );
        wp_enqueue_style( 'mpress-theme-style' );
    } // end mpress_styles
    add_action( 'wp_enqueue_scripts', 'mpress_styles' );
} // endif
/* -------------------------------------------------------------------------- */

/**
 * Enqueue Editor Stylesheet(s)
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/Editor_Style
 */
if ( !function_exists( 'mpress_editor_styles' ) ) {
    function mpress_editor_styles() {
        add_editor_style( MPRESS_STYLES_URI . 'editor.css' );
    } // end mpress_editor_styles
    add_action( 'init', 'mpress_editor_styles' );
} // endif
/* -------------------------------------------------------------------------- */

/**
 * Enqueue Admin Stylesheet(s)
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
 */
if ( !function_exists( 'mpress_admin_styles' ) ) {
    function mpress_admin_styles() {
        // register style
        wp_register_style( 'mpress-admin-style', MPRESS_STYLES_URI . 'admin.css', false, null);
        // Engueue style
        wp_enqueue_style( 'mpress-admin-style' );
    } // end mpress_admin_styles
    add_action( 'admin_enqueue_scripts', 'mpress_admin_styles' );
} // endif
/* -------------------------------------------------------------------------- */

/**
 * Enqueue Login Stylesheet(s)
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
 */
if ( !function_exists( 'mpress_login_styles' ) ) {
    function mpress_login_styles() {
        wp_register_style( 'mpress-login-style', MPRESS_STYLES_URI . '/login.css', false, null );
        wp_enqueue_style( 'mpress-login-style' );
    }
    add_action( 'login_enqueue_scripts', 'mpress_login_styles' );
}
/* -------------------------------------------------------------------------- */

/**
 * Enqueue Front-End Script(s)
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/Function_Reference/wp_enqueue_script
 */
if ( !function_exists( 'mpress_scripts' ) ) {
    function mpress_scripts() {
        // Conditionally load jquery from google
        if( get_theme_mod( 'mpress_enqueue_jquery', 'wordpress' ) == 'google' ) {
            // Set location flag ( true / false )
            $in_footer = get_theme_mod( 'mpress_jquery_location', false );
            // Deregister core jquery
            wp_deregister_script( 'jquery' );
            // (re)Register our own version of jquery
            wp_register_script( 'jquery', "//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js", false, null, $in_footer );
        }
        // Register remaining scripts
        wp_register_script( 'modernizer', MPRESS_SCRIPTS_URI . 'vendor/modernizr.custom.js', array(), null, false );
        wp_register_script( 'mpress-theme-script', MPRESS_SCRIPTS_URI . 'min/mpress.min.js', array( 'jquery' ), null, true );

        // Engueue Scripts
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'modernizer' );
        wp_enqueue_script( 'mpress-theme-script' );

        // Conditionally engueue comment reply script
        if( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    } // end mpress_scripts
} // endif
add_action( 'wp_enqueue_scripts', 'mpress_scripts' );
/* -------------------------------------------------------------------------- */

/**
 * Enqueue Admin Script(s)
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
 */
if ( !function_exists( 'mpress_admin_scripts' ) ) {
    function mpress_admin_scripts() {
        // register scripts
        wp_register_script( 'mpress-admin-script', MPRESS_SCRIPTS_URI . 'min/admin.min.js', array( 'jquery' ), null, true );
        // Engueue Scripts
        wp_enqueue_script( 'mpress-admin-script' );
    } // end mpress_admin_scripts
    add_action( 'admin_enqueue_scripts', 'mpress_admin_scripts' );
} // endif
/* -------------------------------------------------------------------------- */

/**
 * Register Nav Menus
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/Function_Reference/register_nav_menus
 */
if ( !function_exists( 'mpress_register_menus' ) ) {
    function mpress_register_menus() {
        register_nav_menus( array (
            'banner-navbar'   => __( 'Top Banner Nav Bar', 'mpress' ),
            'primary-navbar'  => __( 'Primary Nav Bar', 'mpress' ),
            'off-canvas-nav'  => __( 'Off Canvas ( Mobile ) Menu', 'mpress' ),
            'footer-navbar'   => __( 'Footer Nav Bar', 'mpress' ),
        ) );
    } // end mpress_register_menus
    add_action( 'after_setup_theme', 'mpress_register_menus' );
} // endif
/* -------------------------------------------------------------------------- */

/**
 * Register Widget Area(s)
 * @since version 1.0.0
 * @see   http://codex.wordpress.org/Widgetizing_Themes
 */
if ( !function_exists( 'mpress_widgets_init' ) ) {
    function mpress_widgets_init() {
        register_sidebar( array (
<<<<<<< HEAD
            'name'          => __( 'Primary Sidebar', 'mpress' ),
            'id'            => 'primary-sidebar',
=======
            'name'          => __( 'Contact Column 1', 'mpress' ),
            'id'            => 'contact-1',
            'before_widget' => '<div id="%1$s" class="widget group %2$s">',
            'after_widget'  => "</div>",
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        ) );
        register_sidebar( array (
            'name'          => __( 'Contact Column 2', 'mpress' ),
            'id'            => 'contact-2',
            'before_widget' => '<div id="%1$s" class="widget group %2$s">',
            'after_widget'  => "</div>",
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        ) );
        register_sidebar( array (
            'name'          => __( 'Social', 'mpress' ),
            'id'            => 'foot-info',
>>>>>>> 55a4cfbaa05dd3e246828f3c78e34e4f546e762c
            'before_widget' => '<div id="%1$s" class="widget group %2$s">',
            'after_widget'  => "</div>",
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        ) );
    } // end wpstock_widgets_init
    add_action( 'widgets_init', 'mpress_widgets_init' );
} // endif
/* -------------------------------------------------------------------------- */

/**
 * Remove Authomatically injected style for recent comments widget
 * @since version 1.0.0
 */
if ( !function_exists( 'mpress_remove_recent_comments_style' ) ) {
    function mpress_remove_recent_comments_style() {
        global $wp_widget_factory;
        remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'  ) );
    } // end mpress_remove_recent_comments_style
    add_action( 'widgets_init', 'mpress_remove_recent_comments_style' );
} // endif
<<<<<<< HEAD
/* -------------------------------------------------------------------------- */
=======
/* -------------------------------------------------------------------------- */
>>>>>>> 55a4cfbaa05dd3e246828f3c78e34e4f546e762c
