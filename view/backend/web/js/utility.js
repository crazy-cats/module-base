/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery' ], function( $ ) {

    var self = {

        actButton: function( options ) {

            var opts = $.extend( {
                wrapper: null,
                actions: {
                    redirect: function( params ) {
                        self.loading( true );
                        window.location.href = params.url;
                    },
                    save: function( params ) {
                        self.loading( true );
                        $( params.target ).append( '<input type="hidden" name="to_list" value="1" />' ).submit();
                    },
                    saveContinue: function( params ) {
                        self.loading( true );
                        $( params.target ).submit();
                    }
                }
            }, options );

            $( opts.wrapper ).find( 'button' ).each( function() {
                var button = $( this );
                if ( opts.actions[button.data( 'action' ).type] ) {
                    button.on( 'click', function() {
                        opts.actions[button.data( 'action' ).type]( button.data( 'action' ).params );
                    } );
                }
            } );

        },

        encodeAttr: function( str ) {
            return str.replace( /&/g, '&amp;' )
                    .replace( /</g, '&lt;' )
                    .replace( />/g, '&gt;' )
                    .replace( /"/g, '&quot;' )
                    .replace( /'/g, '&apos;' );
        },

        loading: function( flag ) {
            if ( flag ) {
                if ( $( 'body > .loader' ).length === 0 ) {
                    $( 'body' ).append( '<div class="loader"></div>' );
                }
                $( 'body > .loader' ).show();
            } else {
                $( 'body > .loader' ).hide();
            }
        }

    };

    return self;

} );