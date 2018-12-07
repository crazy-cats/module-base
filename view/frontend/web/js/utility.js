/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery' ], function( $ ) {

    return {
        encodeAttr: function( str ) {
            return str.replace( /&/g, '&amp;' )
                    .replace( /</g, '&lt;' )
                    .replace( />/g, '&gt;' )
                    .replace( /"/g, '&quot;' )
                    .replace( /'/g, '&apos;' );
        }
    };

} );