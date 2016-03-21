<?php
/**
 * Custom Content Blocks
 * Repeatable content blocks custom post type
 * Define and register 'content_block' and related metaboxes, function, etc
 * @package mpress
 * @since  version 1.0.0
 * @see    https://codex.wordpress.org/Post_Types
 */

class Mpress_Content_Blocks {
    /**
     * Theme Name
     * Unique name for this theme
     * @since 1.0.0
     */
    private $theme_name;

    /**
     * Constructor
     * Methods to call when we construct the events class
     * @since 1.0.0
     */
    public function __construct( $theme_name ) {
        $this->theme_name = $theme_name;

        $this->add_actions();
        $this->add_filters();
        $this->add_shortcodes();
    }

    /**
     * Add Actions
     * Register action hooks with Wordpress
     * @see   https://codex.wordpress.org/Plugin_API/Action_Reference
     * @since 1.0.0
     */
    private function add_actions() {
        add_action( 'init', array( $this, 'register_post_type' ), 0 );
        add_action( 'content_block', array( $this, 'post_type_template_tag' ), 10, 1);
        add_action( 'manage_content_block_posts_custom_column', array( $this, 'manage_post_type_column_contents' ), 10, 2 );
    }

    /**
     * Add Filters
     * Register filter hooks with Wordpress
     * @see   https://codex.wordpress.org/Plugin_API/Filter_Reference
     * @since 1.0.0
     */
    private function add_filters() {
        add_filter( 'manage_edit-content_block_columns', array( $this, 'manage_post_type_column_headings' ) );
    }

    /**
     * Add Shortcodes
     * register shortcodes with Wordpress
     * @see   https://codex.wordpress.org/Shortcode_API
     * @since 1.0.0
     */
    private function add_shortcodes() {
        add_shortcode( 'content_block', array( $this, 'post_type_shortcode' ) );
    }

    /**
     * Register post type
     * @see   https://codex.wordpress.org/Function_Reference/register_post_type
     * @since 1.0.0
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x( 'Content Blocks', 'Post Type General Name', $this->theme_name ),
            'singular_name'         => _x( 'Content Block', 'Post Type Singular Name', $this->theme_name ),
            'menu_name'             => __( 'Content Blocks', $this->theme_name ),
            'name_admin_bar'        => __( 'Content Blocks', $this->theme_name ),
            'parent_item_colon'     => __( 'Parent Block:', $this->theme_name ),
            'all_items'             => __( 'All Blocks', $this->theme_name ),
            'add_new_item'          => __( 'Add New Block', $this->theme_name ),
            'add_new'               => __( 'Add New', $this->theme_name ),
            'new_item'              => __( 'New Block', $this->theme_name ),
            'edit_item'             => __( 'Edit Block', $this->theme_name ),
            'update_item'           => __( 'Update Block', $this->theme_name ),
            'view_item'             => __( 'View Block', $this->theme_name ),
            'search_items'          => __( 'Search Blocks', $this->theme_name ),
            'not_found'             => __( 'Not found', $this->theme_name ),
            'not_found_in_trash'    => __( 'Not found in Trash', $this->theme_name ),
            'items_list'            => __( 'Block list', $this->theme_name ),
            'items_list_navigation' => __( 'Block list navigation', $this->theme_name ),
            'filter_items_list'     => __( 'Filter block list', $this->theme_name ),
        );
        $args = array(
            'label'                 => __( 'Content Block', $this->theme_name ),
            'description'           => __( 'Content Blocks', $this->theme_name ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt', 'revisions' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-text',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'page',
        );
        register_post_type( 'content_block', $args );
    }

    /**
     * Edit Column Headings
     * @param  $columns => array, string(s)
     * @return $columns => array, string(s) (new)
     * @since  1.0.0
     * @see    https://codex.wordpress.org/Plugin_API/Action_Reference/manage_posts_custom_column
     */
    public function manage_post_type_column_headings( $columns ) {
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'title'     => __( 'Title' ),
            'id'        => __( 'ID' ),
            'shortcode' => __( 'Shortcode' ),
            'date'      => __( 'Date' )
        );
        return $columns;
    }

    /**
     * Edit Column Contents for custom columns
     * @since 1.0.0
     * @param $column => string, $post_id => int
     * @see   https://codex.wordpress.org/Plugin_API/Action_Reference/manage_posts_custom_column
     */
    public function manage_post_type_column_contents( $column, $post_id ) {
        switch( $column ) {
            case 'id' :
                echo $post_id;
                break;
            case 'shortcode' :
                echo '[content_block id="' . $post_id . '"]';
            default :
                break;
        } // end switch
    }

    /**
     * Add Shortcode Support
     * @since 1.0.0
     * @param $atts => array
     * @see   https://codex.wordpress.org/Function_Reference/add_shortcode
     */
    public function post_type_shortcode( $atts = array() ) {
        // if attributes are empty, return
        if( empty( $atts ) ) {
            return;
        }
        // Merge default attributes with attributes passed in
        $atts = shortcode_atts( array( 'id' => null, 'title' => null ), $atts, 'content_block' );
        // Check if ID is passed in, and ID exists
        if( $atts['id'] && get_post_status( $atts['id'] ) ) {
            return $this->get_content_block_by_id( $atts['id'] );
        }
        // Else, check if title is passed in, and if Title exists
        else if( $atts['title'] && get_post_status( $atts['title'] ) ) {
            return $this->get_content_block_by_title( $atts['title'] );
        }
        // Lastly, if we've made it here, we have nothing to return...so return nothing
        return;
    }

    /**
     * Add template tag
     * @since 1.0.0
     * @param $args (array) Either ID or title passed in from
     */
    public function post_type_template_tag( $args = array() ) {
        // If no args passed in, return
        if( empty( $args )  ) {
            return;
        }
        // Define default args
        $default_args = array( 'id' => null, 'title' => null );
        // Merge default_args with those passed in
        $args = wp_parse_args( $args, $default_args );
        // Check if ID is passed in, and ID exists
        if( $args['id'] && get_post_status( $args['id'] ) ) {
            echo $this->get_content_block_by_id( $args['id'] );
        }
        // Else, check if title is passed in, and if Title exists
        else if( $args['title'] && get_post_status( $args['title'] ) ) {
            echo apply_filters('the_content', $this->get_content_block_by_title( $args['title'] ) );
        }
        // If we've made it here, we have nothing to return...so return nothing
        return;
    }

    /**
     * Query content block by id
     * Returns content of single content block
     * @since  1.0.0
     * @access private
     * @param  (int) $id : unique post ID of content block
     * @return (string)  : content of content block
     */
    private function get_content_block_by_id( $id ) {
        // Initialize output
        $output = '';
        // Define the query
        $the_query = new WP_Query( array( 'post_type' => 'content_block', 'p' => $id, 'post_count' => 1 ) );
        // Construct output loop
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            // Output content of content block
            $output = apply_filters('the_content', get_the_content() );
            // Reset post data
            wp_reset_postdata();
        endwhile; endif;
        // Return contents for output to the page
        return $output;
    }

    /**
     * Query content block by title
     * @since 1.0.0
     * @access private
     * @param  (string) $title : title of the content block
     * @return (string)        : content of content block
     */
    private function get_content_block_by_title( $title ) {
        // Initialize output
        $output = '';
        // define the query
        $the_query = new WP_Query( array( 'post_type' => 'block', 'name' => $title, 'post_count' => 1 ) );
        // Construct output loop
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            // Output content of content block
            $output = apply_filters('the_content', get_the_content() );
            // Reset post data
            wp_reset_postdata();
        endwhile; endif;
        // Return contents for output to the page
        return $output;
    }

} // end class

/**
 * Instantiate our custom post type class
 * @since 1.0.0
 */
$mpress_content_blocks = new Mpress_Content_Blocks( 'mpress' );
