<form role="search" method="get" class="search_form" action="<?php echo get_site_url(); ?>/">

    <label class="screen-reader-text"><?php esc_html_e( 'Search', 'mpress' ); ?></label>

    <div class="field_wrapper">
        <input type="search" class="search_input" placeholder="<?php esc_html_e( 'Search', 'mpress' ); ?> &hellip;" value="" name="s" title="Search">
    </div>

    <div class="field_wrapper">
        <button type="submit" class="search_submit"><span class="icon fa fa-search"></span>&nbsp;<span class="screen-reader-text"><?php esc_html_e( 'Search', 'mpress' ); ?></span></button>
    </div>

</form>