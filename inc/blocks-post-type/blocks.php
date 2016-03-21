<?php
/**
 * Custom Content Blocks
 * Repeatable content blocks custom post type
 * Define and register 'blocks' and related metaboxes, function, etc
 * @package mpress
 * @since version 1.0.0
 * @see https://codex.wordpress.org/Post_Types
 */

class mpress_Content_Blocks {
    /**
     * Constructor
     * Methods to call when we construct the events class
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ), 0 );
        add_action( 'mpress_content_block', array( $this, 'get_content_block' ) );
        add_filter( 'manage_edit-block_columns', array( $this, 'manage_post_type_column_headings' ) );
        add_action( 'manage_block_posts_custom_column', array( $this, 'manage_post_type_column_contents' ), 10, 2 );
        add_shortcode( 'block', array( $this, 'add_post_type_shortcode' ) );
    }
    /**
     * Register post type
     * @since 1.0.0
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x( 'Content Blocks', 'Post Type General Name', 'mpress' ),
            'singular_name'         => _x( 'Content Block', 'Post Type Singular Name', 'mpress' ),
            'menu_name'             => __( 'Content Blocks', 'mpress' ),
            'name_admin_bar'        => __( 'Content Blocks', 'mpress' ),
            'parent_item_colon'     => __( 'Parent Block:', 'mpress' ),
            'all_items'             => __( 'All Blocks', 'mpress' ),
            'add_new_item'          => __( 'Add New Block', 'mpress' ),
            'add_new'               => __( 'Add New', 'mpress' ),
            'new_item'              => __( 'New Block', 'mpress' ),
            'edit_item'             => __( 'Edit Block', 'mpress' ),
            'update_item'           => __( 'Update Block', 'mpress' ),
            'view_item'             => __( 'View Block', 'mpress' ),
            'search_items'          => __( 'Search Blocks', 'mpress' ),
            'not_found'             => __( 'Not found', 'mpress' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'mpress' ),
            'items_list'            => __( 'Block list', 'mpress' ),
            'items_list_navigation' => __( 'Block list navigation', 'mpress' ),
            'filter_items_list'     => __( 'Filter block list', 'mpress' ),
        );
        $args = array(
            'label'                 => __( 'Content Block', 'mpress' ),
            'description'           => __( 'Content Blocks', 'mpress' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'custom-fields', ),
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
        register_post_type( 'block', $args );
    }
    /**
     * Edit Column Headings
     * @param $columns => array, string(s)
     * @return $columns => array, string(s) (new)
     * @since 1.0.0
     * @see https://codex.wordpress.org/Plugin_API/Action_Reference/manage_posts_custom_column
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
     * @see https://codex.wordpress.org/Plugin_API/Action_Reference/manage_posts_custom_column
     */
    public function manage_post_type_column_contents( $column, $post_id ) {
        switch( $column ) {
            case 'id' :
                echo $post_id;
                break;
            case 'shortcode' :
                echo '[block id="' . $post_id . '"]';
            default :
                break;
        } // end switch
    }
    /**
     * Add Shortcode Support
     * @since 1.0.0
     * @param $atts => array
     * @see https://codex.wordpress.org/Function_Reference/add_shortcode
     */
    public function add_post_type_shortcode( $atts = array() ) {
        // if attributes are empty, return
        if( empty( $atts ) ) {
            return;
        }
        // Extract shortcode / merge with defaults
        // extract( shortcode_atts( array( 'id' => null, 'title' => null ), $atts ) );
        $args = shortcode_atts( array( 'id' => null, 'title' => null ), $atts );
        // if post doesn't exist, return
        if( $args['id'] && get_post_status( $args['id'] ) ) {
            return $this->get_content_block_by_id( $args['id'] );
        }
        else if( $args['title'] && get_post_status( $args['title'] ) ) {
            return $this->get_content_block_by_title( $args['title'] );
        }
        // If we've made it here, we have nothing to return...so return nothing
        return;
    }
    /**
     * Get block by template function (do_action)
     * @since 1.0.0
     * @param $atts => array
     */
    public function get_content_block( $args ) {
        // If no args passed in, return
        if( empty( $args )  ) {
            return;
        }
        // Merge defaults with args
        $default_args = array( 'id' => null, 'title' => null );
        $args = array_merge( $default_args, $args );
        // return post by id, if post exists
        if( $args['id'] && get_post_status( $args['id'] ) ) {
            echo $this->get_content_block_by_id( $args['id'] );
        }
        // return post by title, if post exists
        else if( $args['title'] && get_post_status( $args['title'] ) ) {
            echo $this->get_content_block_by_title( $args['title'] );
        }
        // If we've made it here, we have nothing to return...so return nothing
        return;
    }
    /**
     * Query content by id
     * @since 1.0.0
     * @param $atts => array
     */
    public function get_content_block_by_id( $id ) {
        // Start output buffer
        ob_start();
        $the_query = new WP_Query( array( 'post_type' => 'block', 'p' => $id, 'post_count' => 1 ) );

        // Construct output loop
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            // Output content of content block
            the_content();
            // Reset post data
            wp_reset_postdata();
        endwhile; endif;
        // Get contents of output buffer
        $output = ob_get_contents();
        // End & clean output buffer
        ob_end_clean();
        // Return contents for output to the page
        return $output;
    }
    /**
     * Query content by name
     * @since 1.0.0
     * @param $atts => array
     */
    public function get_content_block_by_title( $title ) {
        // Start output buffer
        ob_start();
        $the_query = new WP_Query( array( 'post_type' => 'block', 'name' => $title, 'post_count' => 1 ) );
        // Construct output loop
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            // Output content of content block
            the_content();
            // Reset post data
            wp_reset_postdata();
        endwhile; endif;
        // Get contents of output buffer
        $output = ob_get_contents();
        // End & clean output buffer
        ob_end_clean();
        // Return contents for output to the page
        return $output;
    }

} // end class

/**
 * Instantiate our custom post type class
 * @since 1.0.0
 */
$mpress_content_blocks = new mpress_Content_Blocks;
