(function( $ ) {
    'use strict';
    $.fn.touchmenu = function() {
        // If modernizer is loaded, and were not on a touch device, lets bail
        // if (typeof Modernizr == 'object' && !Modernizr.touch ) {
        //   return false;
        // }

        function toggle_item( nav_item ) {
            // Cache dom
            var nav_item      = nav_item;
            var nav_links     = nav_item.children( 'a' );
            var toggle_button = nav_item.children( '.dropdown-toggle' );
            var sub_nav       = nav_item.children( 'ul' );
            var parent_nav    = nav_item.parents( 'li' );

            // Open menu
            function open_menu( event ) {
                // If menu is already expanded, let it flow
                if( is_visible( sub_nav ) ) {
                    return true;
                // Else if menu uses a toggle button, let the click flow
                } else if( toggle_button.length && is_visible( toggle_button ) ) {
                    return true;
                } else {
                    // Stop browser from following link
                    event.preventDefault();
                    // Add aria expanded and expanded class
                    nav_item.addClass( 'expanded' ).attr( 'aria-expanded', true );
                    sub_nav.addClass( 'expanded' ).attr( 'aria-expanded', true );
                    // Trigger focus
                    nav_item.trigger( 'focus' );
                }
                return true;
            }
            function toggle_menu( event ) {
                event.preventDefault();
                // Give or remove focus
                if( is_visible( sub_nav ) ) {
                    nav_item.blur();
                } else {
                    nav_item.trigger( 'focus' );
                }
                // Toggle Class and aria expanded
                toggle_button.toggleClass( 'expanded' );
                nav_item.toggleClass( 'expanded' );
                toggle_button.attr( 'aria-expanded', function( index, attr ) {
                    return attr === 'false' ? 'true' : 'false';
                });
                return true;
            }

            // Close menu
            function close_menu() {
                nav_item.removeClass( 'expanded' ).attr( 'aria-expanded', false );
                sub_nav.removeClass( 'expanded' ).attr( 'aria-expanded', false );
                if( toggle_button.length ) {
                    toggle_button.removeClass( 'expanded' ).attr( 'aria-expanded', false );
                }
                nav_item.blur();
                return true;
            }
            // check if item is visible
            function is_visible( element ) {
                if( element.css( 'visibility') === 'hidden' || element.css( 'display' ) === 'none' ) {
                    return false;
                }
                return true;
            }
            return {
                open      : open_menu,
                close     : close_menu,
                toggle    : toggle_menu,
                nav_links : nav_links,
                button    : toggle_button,
            }
        };
        // Cache dom
        var $listitems = this.find( 'li.menu-item-has-children' );
        var dropdowns = $.map( $listitems, function( element ) {
            return new toggle_item( $( element ) );
        });
        // Bind handlers
        $.each( dropdowns, function( index, element ) {
            // Call open menu function on click
            element.nav_links.on( 'click', element.open );
            // Call toggle function on button click
            element.button.on( 'click', element.toggle );
        });

        $(document).on( 'click', close );

        function close( event ) {
            $.each( $listitems, function( index, el ) {
                if( !$.contains( el, event.target ) ) {
                    dropdowns[index].close();
                }
            });
        }
        function closeAll() {
            $.each( dropdowns, function( index, element ) {
                element.close();
            });
        }
        return {
            closeAll : closeAll
        }
    }; // end plugin
}( jQuery ));


(function( $ ) {
    'use strict';
$.fn.awesomeSauce = function( options ) {
        // Privatize menu
        var menu = this;
        // Define single dropdown object
        function Dropdown( el ) {
            var dropdown = {
                init : function( el ) {
                    this.$el = el;
                    this.cacheDom();
                    return this;
                },
                cacheDom : function() {
                    this.$links  = this.$el.children( 'a' );
                    this.$toggle = this.$el.children( '.dropdown-toggle' );
                    this.$sub    = this.$el.children( 'ul' );
                },
                open : function() {
                    // Stop browser from following link

                    // Add aria expanded and expanded class to both the parent & sub nav
                    this.$el.addClass( 'expanded' ).attr( 'aria-expanded', true );
                    this.$sub.addClass( 'expanded' ).attr( 'aria-expanded', true );
                    // If this has a toggle button, expand that too
                    if( this.$toggle.length && this.isVisible( this.$toggle ) ) {
                        this.$toggle.addClass( 'expanded' ).attr( 'aria-expanded', true );
                    };
                    // Trigger focus
                    this.$el.get(0).focus();
                    return true;
                },
                close : function() {
                    // Remove class & aria-expanded from element and sub menu
                    this.$el.removeClass( 'expanded' ).attr( 'aria-expanded', false );
                    this.$sub.removeClass( 'expanded' ).attr( 'aria-expanded', false );
                    // If it has a toggle button, remove class and aria-expanded from that too
                    if( this.$toggle.length ) {
                        this.$toggle.removeClass( 'expanded' ).attr( 'aria-expanded', false );
                    }
                    // Lets blur that el
                    this.$el.blur();
                    return true;
                },
                isVisible : function( el ) {
                    if( el.css( 'visibility') === 'hidden' || el.css( 'display' ) === 'none' ) {
                        return false;
                    }
                    return true;
                }
            };
            return dropdown.init( el );
        }
        // Cache the dom elements needed
        var cacheDom = function() {
            menu.$listitems = menu.find( 'li.menu-item-has-children' );
            menu.dropdowns = $.map( menu.$listitems, function( element ) {
                return new Dropdown( $( element ) );
            });
        };
        // Bind event handlers
        var bindEvents = function() {
            // Bind handlers
            $.each( menu.dropdowns, function( index, el ) {
                // Call open menu function on click
                el.$links.on( 'click', toggleLink.bind( el ) );
                // Call focus event on links
                el.$links.on( 'focus', toggleFocus.bind( el ) );
                // Call toggle function on button click
                el.$toggle.on( 'click', toggleButton.bind( el ) );
                // Close when you click elsewhere
                $('body').on( 'click', toggleDocument.bind( el ) );
                // $(window).on( 'touchend', toggleDocument.bind( el ) );
                el.on( 'blur', function() {
                    el.close();
                });
            });
        };
        var toggleFocus = function( event ) {
            // Close other menus
            $.each( menu.$listitems, function( index, el ) {
                if( !$.contains( el, event.target ) ) {
                    menu.dropdowns[index].close();
                }
            });
            // Open this one
            return this.open();
        };
        var toggleLink = function( event ) {
            // If menu is already expanded, let it flow
            if( this.isVisible( this.$sub ) ) {
                return true;
            // Else if menu uses a toggle button, let it flow
            } else if( this.$toggle.length && this.isVisible( this.$toggle ) ) {
                return true;
            }
            // If we've made it here, let's expand it
            event.preventDefault();
            return this.open();
            // return true;
        };
        var toggleButton = function( event ) {
            event.preventDefault();
            // If sub is visible, close it
            if( this.isVisible( this.$sub ) ) {
                return this.close();
            // Else open it
            } else {
                return this.open();
            }
        };
        var toggleDocument = function( event ) {
            // If this is a toggle button, we don't want to close stuff
            var target = $( event.target );
            if( target.hasClass( 'dropdown-toggle' ) || target.parent( '.dropdown-toggle' ).length ) {
                return true;
            } else {
                // Close each dropdown, unless it contains the target
                $.each( menu.$listitems, function( index, el ) {
                    if( !$.contains( el, target ) ) {
                        menu.dropdowns[index].close();
                    }
                });
                return true;
            }
        };
        this.init = function() {
            cacheDom();
            bindEvents();
            return this;
        };
        this.closeDropdowns = function() {
            $.each( menu.dropdowns, function( index, el ) {
                el.close();
            });
        };
        return this.init();
    }; // end plugin
}( jQuery ));
// Protect the global namespace
if( $ ) { $.noConflict(); }
// Document ready function
jQuery( document ).ready(function($) {
    'use strict';
    var indicator = {
        init : function() {
            this.cacheDom();
        },
        cacheDom : function() {
            this.$mark = $( '#makers-mark' );
        },
        breakpoint : function() {
            return this.$mark.css( 'opacity' ) * 10;
        }
    };
    indicator.init();
    $( '.menu-toggle' ).menutoggler();

    var menu = $( '.menu' ).awesomeSauce();
    // $( '.dropdown-toggle' ).on( 'click', function() {
    //     var button = $( this );
    //     var item   = button.parent( 'li' );
    //     button.toggleClass( 'expanded' );
    //     item.toggleClass( 'expanded' );
    //     button.attr( 'aria-expanded', function( index, attr ) {
    //         return attr === 'false' ? 'true' : 'false';
    //     });
    // });
    // $( '#site-navigation' ).touchmenu();
    // Close menu's on resize
    $( window ).resize(function() {
      if( indicator.breakpoint() >= 3 ) {
        menu.closeDropdowns();
      }
    });
});