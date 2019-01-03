/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ ], function() {

    return function( string, params ) {
        params = params || [ ];
        var translations = window.localStorage.getItem( window.translationStorageName );
        translations = translations ? JSON.parse( translations ) : {};
        var translatedText = translations[string] || string;
        for ( var k = 0; k < params.length; k++ ) {
            translatedText = translatedText.replace( '%' + (k + 1), params[k] );
        }
        return translatedText;
    };

} );