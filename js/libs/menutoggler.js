(function( $ ) {
    'use strict';
    $.fn.menutoggler = function() {
        // Get the button object right away
        var button = this;
        // Define toggler object
        var toggler = {
            init: function() {
                this.cacheDom();
                this.bindEvents();
            },
            cacheDom : function() {
                this.$el       = button;
                this.$controls = $.map( this.$el.data( 'targets' ).split( ' ' ), function( element ) {
                    return $( element );
                });
            },
            bindEvents : function() {
                this.$el.on( 'click', this.toggleMenu.bind( this ) );
                this.$el.on( 'click', this.toggleButton.bind( this ) );
            },
            toggleMenu : function( event ) {
                // Prevent any default operation, such as reloading page
                event.preventDefault();
                // Iterate over each target and toggle class / aria / expanded attribute ( if present )
                $.each( this.$controls, function( index, element ) {
                    // toggle open class
                    element.toggleClass( 'open' );
                    // Expand aria-expanded only if it has the aria attribute
                    if( element.attr( 'aria-expanded' ) !== undefined ) {
                        element.attr( 'aria-expanded', function( index, attr ) {
                            return attr === 'false' ? 'true' : 'false';
                        });
                    }
                });
            },
            toggleButton : function( event ) {
                // Prevent any default operation, such as reloading page
                event.preventDefault();
               // Toggle button class / aria-expanded attribute
               this.$el.toggleClass( 'open' ).attr( 'aria-expanded', function( index, attr ) {
                   return attr === 'false' ? 'true' : 'false';
               });
            }
        } // end toggler object
        toggler.init();
    }; // end menu toggler function
}( jQuery ));