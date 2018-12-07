/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

define( [ 'jquery' ], function( $ ) {

    return function( options ) {

        var opts = $.extend( {
            wrapper: null,
            actions: {
                redirect: function( params ) {
                    window.location.href = params.url;
                },
                save: function( params ) {
                    $( params.target ).append( '<input type="hidden" name="to_list" value="1" />' ).submit();
                },
                saveContinue: function( params ) {
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

    };

} );