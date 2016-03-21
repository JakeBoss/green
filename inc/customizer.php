<?php
/**
 * mpress Theme Customizer.
 * @package mpress
 */

class Mpress_Theme_Customizer {
    private $sections;
    private $settings;
    private $controls;

    public function __construct() {
        // $this->init_customizer_settings();
        // add_action( 'customize_register', array( $this, 'register_customizer_sections' ) );
        // add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
        // add_action( 'customize_register', array( $this, 'register_customizer_controls' ) );
        add_action( 'customize_register', array( $this, 'core_theme_settings' ) );
        add_action( 'customize_register', array( $this, 'social_settings' ) );
        add_action( 'customize_register', array( $this, 'mpress_register_custom_logo' ) );
        add_action( 'customize_update_image_theme_mod', array( $this, 'customize_update_image_theme_mod' ), 10, 2 );
    }
    public function core_theme_settings( $wp_customize ) {
        // define section
        $section = array(
            'cabability'  => 'edit_theme_options',
            'title'       => __( 'Core Theme Settings', 'mpress' ),
            'description' => __( 'Customize Core Theme Settings' ),
            'priority'    => 10
        );
        // Register section
        $wp_customize->add_section( 'core_theme_settings_section', $section );
        // Define Settings
        $settings = array(
            'mpress_enqueue_jquery' => array(
                'default'    => 'wordpress',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh'
            ),
            'mpress_jquery_location' => array(
                'default'    => false,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh'
            ),
            'mpress_archive_type' => array(
                'default'    => 'content',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh'
            ),
            'mpress_mobile_menu' => array(
                'default'    => 'menu-simple',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh'
            )
        );
        // Register Settings
        foreach( $settings as $key => $setting ) {
            $wp_customize->add_setting( $key, $setting );
        }
        // Define Controls
        $controls = array(
            'mpress_enqueue_jquery' => array(
                'label'     => __( 'Jquery Source', 'mpress' ),
                'section'   => 'core_theme_settings_section',
                'settings'  => 'mpress_enqueue_jquery',
                'type'      => 'radio',
                'choices'   => array(
                    'wordpress' => __( 'Wordpress Core', 'mpress' ),
                    'google'    => __( 'Google CDN', 'mpress' )
                )
            ),
            'mpress_jquery_location' => array(
                'label'       => __( 'Load JQuery in footer', 'mpress' ),
                'section'     => 'core_theme_settings_section',
                'settings'    => 'mpress_jquery_location',
                'type'        => 'checkbox'
            ),
            'mpress_archive_type' => array(
                'label'     => __( 'Archive Page Listing Type', 'mpress' ),
                'section'   => 'core_theme_settings_section',
                'settings'  => 'mpress_archive_type',
                'type'      => 'radio',
                'choices'   => array(
                    'content' => __( 'Full Content', 'mpress' ),
                    'excerpt' => __( 'Excerpt', 'mpress' )
                )
            ),
            'mpress_mobile_menu' => array(
                'label'     => __( 'Mobile Menu Type', 'mpress' ),
                'section'   => 'core_theme_settings_section',
                'settings'  => 'mpress_mobile_menu',
                'type'      => 'radio',
                'choices'   => array(
                    'menu-simple'     => __( 'Simple (dropdown) Menu', 'mpress' ),
                    'menu-off-canvas' => __( 'Off Canvas Menu', 'mpress' )
                )
            )
        );
        // Register Controls
        foreach( $controls as $key => $control ) {
            $wp_customize->add_control( $key, $control );
        }
    }
    public function social_settings( $wp_customize ) {
        // Get our list of social networks from the functions.php file
        $social_networks = mpress_social_network_settings();
        // If social networks isn't an array, or it's empty lets bail
        if( !is_array( $social_networks ) || empty( $social_networks ) ) {
            return;
        }
        // Add section
        $section = array(
            'cabability'  => 'edit_theme_options',
            'title'       => __( 'Social Settings', 'mpress' ),
            'description' => __( 'Set Social Network URI\'s' ),
            'priority'    => 10
        );
        $wp_customize->add_section( 'social_settings_section', $section );

        foreach( $social_networks as $key => $network ) {
            // Define Setting
            $setting = array(
                'default'           => $network['default'],
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'transport'         => 'refresh',
                'sanitize_callback' => 'esc_url_raw'
            );
            $wp_customize->add_setting( $network['slug'], $setting );
            // Define control
            $control = array(
                'label'    => $network['label'],
                'section'  => 'social_settings_section',
                'setting'  => $network['slug'],
                'type'     => 'text',
            );
            $wp_customize->add_control( $network['slug'], $control );
        } // end foreach
    }

    public function mpress_register_custom_logo( $wp_customize  ) {
        $settings = array (
            'mpress_site_logo' => array(
                'default'    => null,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh'
            ),
            'mpress_default_featured_image' => array(
                'default'    => null,
                'type'       => 'image_theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh'
            ),
        );
        // Add our settings
        foreach( $settings as $key => $setting ) {
            $wp_customize->add_setting( $key, $setting );
        }

        $controls = array(
            'mpress_site_logo' => array (
                'label'    => __( 'Site Logo', 'mpress' ),
                'section'  => 'title_tagline',
                'settings' => 'mpress_site_logo'
            ),
            'mpress_default_featured_image' => array (
                'label'    => __( 'Default Featured Image', 'mpress' ),
                'section'  => 'core_theme_settings_section',
                'settings' => 'mpress_default_featured_image'
            )
        );
        // Add controls
        foreach( $controls as $key => $control ) {
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, $control ) );
        }
    }

    public function customize_update_image_theme_mod( $value, $WP_Customize_Setting ) {
        $image_id = attachment_url_to_postid ( esc_url_raw( $value ) );
        if( $image_id ) {
            set_theme_mod( sprintf( '%s_id', $WP_Customize_Setting->id ) , $image_id );
        }
        set_theme_mod( $WP_Customize_Setting->id, $value );
    }
} // end class

$mpress_theme_customizer = new mpress_Theme_Customizer();



function mpress_social_options( $wp_customize ) {
    // Define setting section
    $section = array(
        'social_settings_section' => array(
            'cabability'  => 'edit_theme_options',
            'title'       => __( 'Social Settings', 'mpress' ),
            'description' => __( 'Set Social Network URI\'s' ),
            'priority'    => 10
        ),
    );
    // Get social networks
    $social = mpress_social_networks();

    if( empty( $social ) ) {
        return;
    }

    foreach( $social as $key => $args ) {
        // Define Setting
        $setting = array(
            'default'           => $args['default'],
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'transport'         => 'refresh',
            'sanitize_callback' => 'esc_url_raw'
        );
        $wp_customize->add_setting( $args['slug'], $setting );
        // Define control
        $control = array(
            'label'    => $args['label'],
            'section'  => 'social_settings_section',
            'setting'  => $args['slug'],
            'type'     => 'text',
        );
        $wp_customize->add_control( $args['slug'], $control );
    }
}

/**
 * Enqueue customizer javascript
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if( !function_exists( 'mpress_customize_preview_js' ) ) {
    function mpress_customize_preview_js() {
        wp_enqueue_script( 'mpress_customizer', MPRESS_SCRIPTS_URI . 'libs/customizer.js', array( 'customize-preview' ), null, true );
    }
    add_action( 'customize_preview_init', 'mpress_customize_preview_js' );
}
/*----------------------------------------------------------------------------*/

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 * @param (object)$wp_customize : Theme Customizer object.
 */
if( !function_exists( 'mpress_customize_post_messeage' ) ) {
    function mpress_customize_post_messeage( $wp_customize ) {
        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    }
    add_action( 'customize_register', 'mpress_customize_post_messeage' );
}
/*----------------------------------------------------------------------------*/

function mpress_register_custom_logo( $wp_customize  ) {
    $settings = array (
        'mpress_site_logo' => array(
            'default'    => null,
            'type'       => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport'  => 'refresh'
        ),
    );
    // Add our settings
    foreach( $settings as $key => $setting ) {
        $wp_customize->add_setting( $key, $setting );
    }

    $controls = array(
        'mpress_site_logo' => array (
            'label'    => __( 'Site Logo', 'mpress' ),
            'section'  => 'title_tagline',
            'settings' => 'mpress_site_logo'
        )
    );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_logo', array(
        'label'    => __( 'Site Logo', 'mpress' ),
        'section'  => 'title_tagline',
        'settings' => 'mpress_site_logo'
    ) ) );
}

/**
 * Register theme options in customizer
 * @param (object) $wp_customize : Theme Customizer object.
 */
if( !function_exists( 'mpress_customize_theme_options' ) ) {
    function mpress_customize_theme_options( $wp_customize ) {
        // Add panels to customizer
        $panels = array(
            'mpress_theme_options' => array(
                'priority'    => 10,
                'capability'  => 'edit_theme_options',
                'title'       => __( 'Theme Options', 'mpress' ),
                'description' => __( 'Customize Theme Options', 'mpress' ),
            ),
        );
        foreach( $panels as $key => $panel ) {
            $wp_customize->add_panel( $key, $panel );
        }
        // Add sections to panel(s)
        $sections = array(
            'core_theme_settings_section' => array(
                'cabability'  => 'edit_theme_options',
                'title'       => __( 'Core Theme Settings', 'scaffolding' ),
                'description' => __( 'Customize Core Theme Settings' ),
                'panel'       => 'mpress_theme_options',
            ),
        );
        foreach( $sections as $key => $section ) {
            $wp_customize->add_section( $key, $section );
        }
        // Add setting to sections
        $settings = array(
            'mpress_enqueue_jquery' => array(
                'default'    => 'wordpress',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh'
            ),
            'mpress_jquery_location' => array(
                'default'    => false,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh'
            ),
        );
        foreach( $settings as $key => $setting ) {
            $wp_customize->add_setting( $key, $setting );
        }
        // Add controls to settings
        $controls = array(
            'mpress_enqueue_jquery' => array(
                'label'     => __( 'Jquery Source', 'mpress' ),
                'section'   => 'core_theme_settings_section',
                'settings'  => 'mpress_enqueue_jquery',
                'type'      => 'radio',
                'choices'   => array(
                    'wordpress' => __( 'Wordpress Core', 'mpress' ),
                    'google'    => __( 'Google CDN', 'mpress' )
                )
            ),
            'mpress_jquery_location' => array(
                'label'       => __( 'Load JQuery in footer', 'mpress' ),
                'section'     => 'core_theme_settings_section',
                'settings'    => 'mpress_jquery_location',
                'type'        => 'checkbox'
            ),
        );
        foreach( $controls as $key => $control ) {
            $wp_customize->add_control( $key, $control );
        }
    }
}
/*----------------------------------------------------------------------------*/





