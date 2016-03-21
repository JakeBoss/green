<?php
/**
 * FUNCTIONS UNDER DEVELOPMENT - DONT USE IN PRODUCTION YET
 */

function mpress_sharing_links() {
    $buttons = array(
        'facebook' => array(
            'uri'  => sprintf( 'https://www.facebook.com/sharer.php?u=%s"', get_permalink() ),
            'icon' => 'fa fa-facebook',
            'text' => __( 'Facebook', 'mpress' )
        ),
        'twitter' => array(
            'uri'  => sprintf( 'https://twitter.com/share?url=%s&amp;text=%s"', get_permalink(), urlencode( get_the_title() ) ),
            'icon' => 'fa fa-twitter',
            'text' => __( 'Twitter', 'mpress' )
        ),
        'googleplus' => array(
            'uri'  => sprintf( 'https://plus.google.com/share?url=%s"', get_permalink() ),
            'icon' => 'fa fa-google-plus',
            'text' => __( 'Google Plus', 'mpress' )
        ),
        'pinterest' => array(
            'uri'  => sprintf( 'http://pinterest.com/pin/create/link/?url=%s&amp;description=%s"', get_permalink() ),
            'icon' => 'fa fa-pinterest',
            'text' => __( 'pinterest', 'mpress' )
        ),
        'instagram' => array(
            'uri'  => sprintf( 'https://www.facebook.com/sharer.php?u=%s"', get_permalink() ),
            'icon' => 'fa fa-instagram',
            'text' => __( 'Instagram', 'mpress' )
        ),
        'linkedin' => array(
            'uri'  => sprintf( 'http://www.linkedin.com/shareArticle?mini=true&amp;url=%s"', get_permalink() ),
            'icon' => 'fa fa-linkedin',
            'text' => __( 'Linkedin', 'mpress' )
        ),
    );
    // Append twitter handle if set {
    $buttons['twitter']['uri'] .= ( get_option( 'mpress_twitter_handle', null ) ) ? sprintf( '&amp;via=%s', urlencode( get_option( 'mpress_twitter_handle' ) ) ) : '';
    // Append pinterest media, if available
    // &media={URI-encoded URL of the image to pin}
    // 1. Check for custom pinterest image set
    // 2. Check for featured image set
    // 3. Check for image in post
    // 4. Check for default pinterest image from settings
    $output = '<ul class="mpress_sharing">';
    foreach( $buttons as $key => $button ) {
        $output .= sprintf( '<li><a class="%s" href="%s" target="_blank"><span class="icon %s"></span><span class="text">%s</span></a></li>', $key, $button['uri'], $button['icon'], $button['text'] );
    }
    $output .= '</ul>';
    echo $output;
}