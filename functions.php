<?php
/*******************************************************************************
 *                 ______                 __  _
 *                / ____/_  ______  _____/ /_(_)___  ____  _____
 *               / /_  / / / / __ \/ ___/ __/ / __ \/ __ \/ ___/
 *              / __/ / /_/ / / / / /__/ /_/ / /_/ / / / (__  )
 *             /_/    \__,_/_/ /_/\___/\__/_/\____/_/ /_/____/
 *
 ******************************************************************************/

/**
 * Functions
 * Boostrap all custom functions that our theme needs to run
 * @package mpress
 * @see     https://codex.wordpress.org/Functions_File_Explained
 * @since   version 1.0.0
 */

/**
 * Define constants
 * @since version 1.0.1
 */

define( 'MPRESS_ROOT_DIR', trailingslashit( get_template_directory() ) );     // file path of theme directory
define( 'MPRESS_ROOT_URI', trailingslashit( get_template_directory_uri() ) ); // uri of theme directory
define( 'MPRESS_IMAGES_URI', MPRESS_ROOT_URI . 'images/' );                 // uri to image directory
define( 'MPRESS_SCRIPTS_URI', MPRESS_ROOT_URI . 'js/' );                    // uri to javascript directory
define( 'MPRESS_STYLES_URI', MPRESS_ROOT_URI . 'css/' );                    // uri to stylesheet directory
define( 'MPRESS_INC_DIR', MPRESS_ROOT_DIR . 'inc/' );                       // path to includes directory
define( 'MPRESS_THEME_NAME', 'mpress' );                                    // theme slug used for translation

/* -------------------------------------------------------------------------- */

/**
 * Set Content Width
 * @since version 1.0.0
 * @see   https://codex.wordpress.org/Content_Width
 */
if ( !isset( $content_width ) ) {
    $content_width = 1280;
}
/* -------------------------------------------------------------------------- */

/**
 * Get Icons
 * Maintains map of icons used for this theme
 * @since  version 1.0.0
 * @param  (string) $icon   : Name of icon
 * @param  (bool)   $return : whether or not to return a string with icon markup
 * @return (string)         : Icon markup
 */
if( !function_exists( 'get_mpress_icon' ) ) {
    function get_mpress_icon( $icon = null, $return = true ) {
        // If no icon request is passed in, just bail
        if( !$icon ) {
            return false;
        }
        // If user specifies return false, do that
        if( !$return )  {
            return null;
        }
        $icon_map = array(
            'twitter'     => '<span class="icon fa fa-twitter"><span>',
            'facebook'    => '<span class="icon fa fa-facebook"><span>',
            'googleplus'  => '<span class="icon fa fa-google-plus"><span>',
            'youtube'     => '<span class="icon fa fa-youtube"><span>',
            'pinterest'   => '<span class="icon fa fa-pinterest"><span>',
            'linkedin'    => '<span class="icon fa fa-linkedin"><span>',
            'author'      => '<span class="icon fa fa-user"></span>',
            'time'        => '<span class="icon fa fa-clock-o"></span>',
            'category'    => '<span class="icon fa fa-tags"></span>',
            'tag'         => '<span class="icon fa fa-hashtag"></span>',
            'comment'     => '<span class="icon fa fa-comments"></span>',
            'edit'        => '<span class="icon fa fa-pencil"></span>',
            'home'        => '<span class="icon fa fa-home"></span>',
            'toggle-down' => '<span class="icon fa fa-chevron-down"></span>',
        );

        if( isset( $icon_map[ strtolower( $icon ) ] ) ) {
            return $icon_map[ strtolower( $icon ) ];
        }
        return false;
    }
}
/* -------------------------------------------------------------------------- */

/**
 * Set Social Network settings needed for both customizer, and template tags
 * @since version 1.0.0
 */
if( !function_exists( 'mpress_social_network_settings' ) ) {
    function mpress_social_network_settings() {
        $social = array(
            'facebook' => array(
                'slug'    => 'facebook_uri',
                'default' => null,
                'label'   => __( 'Facebook URI', 'mpress' ),
            ),
            'twitter' => array(
                'slug'    => 'twitter_uri',
                'default' => null,
                'label'   => __( 'Twitter URI', 'mpress' ),
            ),
            'googleplus' => array(
                'slug'    => 'googleplus_uri',
                'default' => null,
                'label'   => __( 'Google Plus URI', 'mpress' ),
            ),
            'youtube' => array(
                'slug'    => 'Youtube_uri',
                'default' => null,
                'label'   => __( 'Youtube URI', 'mpress' ),
            ),
            'linkedin' => array(
                'slug'    => 'linkedin_uri',
                'default' => null,
                'label'   => __( 'Linkedin URI', 'mpress' ),
            ),
            'pinterest' => array(
                'slug'    => 'pinterest_uri',
                'default' => null,
                'label'   => __( 'Pinterest URI', 'mpress' ),
            )
        );
        return $social;
    }
}

add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);
function my_embed_oembed_html($html, $url, $attr, $post_id) {
    // Create element to hold our fragments
    $embed = array(
        'width'  => null,
        'height' => null,
        'domain' => null,
    );
    // Create DOM element, and extract code
    $dom = new DOMDocument();
    $dom->loadHTML( $html );
    $el = $dom->getElementsByTagName('iframe');
    // Extract width and height
    if( $el->length ) {
        foreach( $el as $iframe ) {
            $embed['width']  = $iframe->getAttribute( 'width' );
            $embed['height'] = $iframe->getAttribute( 'height' );
        }
    }
    // Get domain
    $embed['domain'] = parse_url( $url );
    // Remove WWW extension
    $embed['domain'] =  str_replace( 'www.', '', $embed['domain']['host'] );
    // Replace remaining periods with dashed
    $embed['domain'] =  preg_replace('/[.]/', '-', $embed['domain'] );
    // Construct Attributes
    $style = ( $embed['height'] && $embed['width'] ) ? sprintf( 'style="padding-bottom: %.3f%%;"', ( $embed['height'] / $embed['width'] ) * 100 ) : null;
    $class = ( $embed['domain'] ) ? sprintf( 'class="oembed flex-video %s"', $embed['domain'] ) : 'class="oembed flex-video"';
    // return output
    return sprintf( '<div %s %s data-url="%s">%s</div>', $class, $style, $url, $html );
}

/**
 * Include CUSTOM THEME HOOKS
 * Custom theme hooks define things such as shortcodes, and template tags
 */
include MPRESS_INC_DIR . 'hooks.php';

/**
 * Include ACTIONS
 * Where we add our menu's & widgets, enqueue stylehseets and scripts, etc
 * @see https://codex.wordpress.org/Plugin_API/Action_Reference
 */
include MPRESS_INC_DIR . 'actions.php';

/**
 * Include FILTERS
 * Where we add our filters, such as removing script versions, adding mimi types, etc
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference
 */
include MPRESS_INC_DIR . 'filters.php';

/**
 * Include WIDGET(S)
 * Where we define any custom theme widgets
 * ( commented out if not using any, only boilerplate included here )
 */
// include MPRESS_INC_DIR . 'widget-boilerplate/widget.php';

/**
 * Include CUSTOM POST TYPE(S)
 * Where we define any custom post types we need
 */
include MPRESS_INC_DIR . 'content_blocks.php';

/**
 * Custom template tags for this theme.
 */
include MPRESS_INC_DIR . 'template_tags.php';

/**
 * Customizer additions.
 */
include MPRESS_INC_DIR . 'customizer.php';

include MPRESS_INC_DIR . 'append_dropdown_buttons.php';

// include MPRESS_INC_DIR . 'truck-systems/class_truck_systems.php';

/**
 * Load Jetpack compatibility file.
 */
//include MPRESS_INC_DIR . 'jetpack.php';

/**
 * Implement the Custom Header feature.
 */
//include MPRESS_INC_DIR . 'custom_header.php';