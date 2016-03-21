<?php
/*******************************************************************************
 *                         _______ ____
 *                        / ____(_) / /____  __________
 *                       / /_  / / / __/ _ \/ ___/ ___/
 *                      / __/ / / / /_/  __/ /  (__  )
 *                     /_/   /_/_/\__/\___/_/  /____/
 *
 *
 ******************************************************************************/
/**
 * Filters
 * Define Filters using the Wordpress Actions / Filters / Hooks Plugin API
 * @package mpress
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference
 * @since version 1.0.0
 */

/**
 * Remove Version Number From Enqueued Scripts & Styles
 * @since version 1.0.0
 */
if ( !function_exists( 'mpress_remove_script_version' ) ) {
    function mpress_remove_script_version( $src ) {
        if ( strpos( $src, 'ver=' ) )
            $src = remove_query_arg( 'ver', $src );
        return $src;
    }   // end mpress_remove_script_version
    add_filter( 'style_loader_src', 'mpress_remove_script_version', 9999 );
    add_filter( 'script_loader_src', 'mpress_remove_script_version', 9999 );
} // endif
/* -------------------------------------------------------------------------- */

/**
 * Remove Version From RSS Feeds (security)
 * @since version 1.0.0
 * @see http://www.wpbeginner.com/wp-tutorials/the-right-way-to-remove-wordpress-version-number/
 */
if ( !function_exists( 'mpress_rss_version' ) ) {
    function mpress_rss_version() {
        return '';
    } // end mpress_rss_version
    add_filter( 'the_generator', 'mpress_rss_version' );
} // endif

/* -------------------------------------------------------------------------- */

/**
 * Remove Empty <P></P> Tags Injected By WP_AUTOP
 * @since version 1.0.0
 */
if ( !function_exists( 'mpress_remove_empty_paragraphs' ) ) {
    function mpress_remove_empty_paragraphs( $content ) {
        return str_replace( '<p></p>', '', force_balance_tags( $content ) );
    } // end remove_empty_paragraphs
    add_filter('the_content', 'mpress_remove_empty_paragraphs', 20, 1);
}

/* -------------------------------------------------------------------------- */

/**
 * Add document mime types in media manager
 * @since version 1.0.0.0
 */
if( !function_exists( 'modify_post_mime_types' ) ) {
    function modify_post_mime_types( $post_mime_types ) {
        $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
        return $post_mime_types;
    }
    // Add Filter Hook
    add_filter( 'post_mime_types', 'modify_post_mime_types' );
}
/* -------------------------------------------------------------------------- */

/**
 * Allow SVG's to be uploaded via the media uploader
 * @since version 1.0.0.0
 */
if( !function_exists( 'mpress_svg_media_upload' ) ) {
    function mpress_svg_media_upload( $mimes ) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
    }
    add_filter('upload_mimes', 'mpress_svg_media_upload');
}
/* -------------------------------------------------------------------------- */

/**
 * Adds custom classes to the array of body classes.
 * @param  (array) $classes : Classes for the body element.
 * @return (array) $classes : Modified classes array for the body element.
 */
if( !function_exists( 'mpress_body_classes' ) ) {
    function mpress_body_classes( $classes ) {
        // Adds a class of group-blog to blogs with more than 1 published author.
        if ( is_multi_author() ) {
            $classes[] = 'group-blog';
        }
        // Add menu type class
        $classes[] = get_theme_mod( 'mpress_mobile_menu', 'menu-simple' );
        // return array of classes
        return $classes;
    }
    add_filter( 'body_class', 'mpress_body_classes' );
}
/* -------------------------------------------------------------------------- */

function mpress_featured_image( $size = 'post-thumbnail' ) {
    // Try to get the image ID
    $image_by_id = get_theme_mod('mpress_default_featured_image_id', null );
    if( $image_by_id !== null ) {
        echo wp_get_attachment_image( $image_by_id, $size );
        return true;
    } else {
        $image_by_src = get_theme_mod('mpress_default_featured_image', null );
        if( $image_by_src !== null ) {
            echo sprintf( '<img src="%s">', $image_by_src );
            return true;
        }
    }
    return false;
}