jQuery( document ).ready(function($) {
    'use strict';

    $.each( $( '.modal' ), function( index, el ) {
        return new ModalWindow( el );
    });

    function ModalWindow( el ) {
      // Cache dom tree
      var modal         = this;
      this.$el          = $( el );
      this.$window      = $( this.$el.data( 'modal' ) );
      this.$closeButton = this.$window.find( '.close-window-btn' );

      // Define open functionality
      function openForm( event ) {
        // Stop window from reloading
        event.preventDefault();
        // Open actual modal
        modal.$window.hide().addClass( 'open' ).fadeIn( 500 );
      }

      // Definen closing functionality
      function closeForm( event ) {
        // Stop window from reloading
        event.preventDefault();
        modal.$window.fadeOut( 500, function() {
          modal.$window.removeClass( 'open' );
        });
      }

      // Bind events
      this.$el.on( 'click', openForm.bind( this ) );
      this.$closeButton.on( 'click', closeForm.bind( this ) );

      // Return object
      return this;
    }

});
