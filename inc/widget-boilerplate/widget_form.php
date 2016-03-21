<p>
    <label for="<?php echo $this->get_field_name( 'title' ); ?>">Title</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_name( 'sample_field_one' ); ?>">SETTING FIELD NAME</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'sample_field_one' ); ?>" name="<?php echo $this->get_field_name( 'sample_field_one' ); ?>" type="text" value="<?php echo esc_attr( $instance['sample_field_one'] ); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_name( 'sample_field_two' ); ?>">SETTING FIELD NAME</label>
    <textarea class="widefat" id="<?php echo $this->get_field_id( 'sample_field_two' ); ?>" name="<?php echo $this->get_field_name( 'sample_field_two' ); ?>"><?php echo esc_textarea( $instance['sample_field_two'] ); ?> </textarea>
</p>