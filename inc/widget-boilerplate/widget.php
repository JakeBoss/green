<?php
/*******************************************************************************
 *   PLUGIN NAME: WIDGET NAME
 *   URI PLUGIN URI: http://www.midwestdigitalmarketing.com
 *   DESCRIPTION: WIDGET DESCRIPTION
 *   VERSION: 1.0.0
 *   AUTHOR: Midwest Digital Marketing Team
 *   AUTHOR URI: http://www.midwestdigitalmarketing.com
 ******************************************************************************/

class Widget_Name extends WP_Widget {

    public $widget_id_base;
    public $widget_name;
    public $widget_options;
    public $control_options;

    /**
     * Constructor, initialize the widget
     * @param $id_base, $name, $widget_options, $control_options ( ALL optional )
     * @since 1.0.0
     */
    public function __construct() {
        $this->widget_id_base = 'widget_id';
        $this->widget_name = 'Long Form Widget Name';
        $this->widget_options = array(
            'classname'   => 'widget_class',
            'description' => 'Long Form Widget Description'
        );
        parent::__construct( $this->widget_id_base, $this->widget_name, $this->widget_options );
    } // end __construct

    /**
     * Create back end form for specifying image and content
     * @param $instance
     * @see https://codex.wordpress.org/Function_Reference/wp_parse_args
     * @since 1.0.0
     */
    public function form( $instance ) {
        // define our default values
        $defaults = array(
            'title'            => null,
            'sample_field_one' => null,
            'sample_field_two' => null,
        );
        // merge instance with default values
        $instance = wp_parse_args( (array)$instance, $defaults );
        // include our form markup
        include plugin_dir_path( __FILE__ ) . 'widget_form.php';
    } // end form()

    /**
     * Update form values
     * @param $new_instance, $old_instance
     * @since 1.0.0
     */
    public function update( $new_instance, $old_instance ) {
        // initially set instance = old_instance, and replace individual values as we validate them
        $instance = $old_instance;
        // escape and set new values
        $instance['title']            = esc_attr( $new_instance['title'] );
        $instance['sample_field_one'] = esc_attr( $new_instance['sample_field_one'] );
        $instance['sample_field_two'] = esc_textarea( $new_instance['sample_field_two'] );
        return $instance;
    } // end update()

    /**
     * Output widget on the front end
     * @param $args, $instance
     * @since 1.0.0
     */
    public function widget( $args, $instance ) {
        // Extract the widget arguments ( before_widget, after_widget, description, etc )
        extract( $args );
        // Instantiate $title to avoid errors
        $title = '';
        // Append before / after title elements if title is not blank
        if( !empty( $instance['title'] ) ) {
            $title = $args['before_title'] . $instance['title'] . $args['after_title'];
        }
        // Display the markup before the widget (as defined in functions.php)
        echo $before_widget;
        // Include our output markup
        include plugin_dir_path( __FILE__ ) . 'widget_output.php';
        // Display the markup after the widget (as defined in functions.php)
        echo $after_widget;
    } // end widget()
} // end class

// Register the widget using an annonymous function
add_action( 'widgets_init', create_function( '', 'register_widget( "Widget_Name" );' ) );