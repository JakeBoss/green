<?php
/*******************************************************************************
 *                            __  __            __
 *                           / / / /___  ____  / /_______
 *                          / /_/ / __ \/ __ \/ //_/ ___/
 *                         / __  / /_/ / /_/ / ,< (__  )
 *                        /_/ /_/\____/\____/_/|_/____/
 *
 ******************************************************************************/
/**
 * Hooks
 * Define Hooks using the Wordpress Actions / Filters / Hooks Plugin API
 * @package mpress
 * @see http://codex.wordpress.org/Plugin_API/Hooks
 * @since version 1.0.0
 */

if( !function_exists( 'mpress_menu_content_shortcode' ) ) {
    function mpress_menu_content_shortcode( $atts ) {
        $args = shortcode_atts( array(
            'theme_location'  => '',
            'menu'            => '',
            'container'       => 'div',
            'container_class' => '',
            'container_id'    => '',
            'menu_class'      => 'menu',
            'menu_id'         => '',
            'echo'            => false,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth'           => 0,
            'walker'          => ''
            ), $atts );
        if( !$args['theme_location'] && !$args['menu'] ) {
            return false;
        }
        return wp_nav_menu( $args );
    }
    add_shortcode('mpress_menu', 'mpress_menu_content_shortcode');
}