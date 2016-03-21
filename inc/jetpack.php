<?php
/**
 * Jetpack Compatibility File.
 * @link    https://jetpack.me/
 * @package mpress
 */

/**
 * Add theme support for Infinite Scroll.
 * @see https://jetpack.me/support/infinite-scroll/
 */
function mpress_jetpack_setup() {
    add_theme_support( 'infinite-scroll', array(
        'container' => 'main',
        'render'    => 'mpress_infinite_scroll_render',
        'footer'    => 'page',
    ) );
}
/* -------------------------------------------------------------------------- */

add_action( 'after_setup_theme', 'mpress_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function mpress_infinite_scroll_render() {
    while ( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/content', get_post_format() );
    }
}
/* -------------------------------------------------------------------------- */
