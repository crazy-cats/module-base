/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery', 'utility', 'CrazyCat/Core/js/validation' ], function( $, utility ) {

    return function( options ) {

        var opts = $.extend( {
            el: null,
            fields: [ ],
            validation: {
                rules: {},
                invalidHandler: function() {
                    utility.loading( false );
                }
            }
        }, options );

        var form = $( opts.el );

        var multiValueTypes = [ 'multiselect' ];
        for ( var groupName in opts.fields ) {
            var fields = opts.fields[groupName].fields;
            for ( var i = 0; i < fields.length; i++ ) {
                if ( fields[i].validation ) {
                    var fieldName = multiValueTypes.indexOf( fields[i].type ) ? ('data[' + fields[i].name + ']') : ('data[' + fields[i].name + '][]');
                    opts.validation.rules[ fieldName ] = fields[i].validation;
                }
            }
        }
        form.validate( opts.validation );

        form.find( '.field-group-label' ).on( 'click', function() {
            $( this ).siblings( '.field-group-content' ).slideDown();
            $( this ).closest( '.field-group' ).siblings().find( '.field-group-content' ).slideUp();
        } ).eq( 0 ).click();

    };

} );