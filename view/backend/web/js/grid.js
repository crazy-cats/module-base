/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery' ], function( $ ) {

    return function( options ) {

        var opts = $.extend( {
            form: null,
            sourceUrl: null,
            fields: [ ],
            sortings: [ ]
        }, options );

        var body = $( 'html,body' );
        var form = $( opts.form );
        var table = form.find( 'table' );

        var updateList = function( result ) {
            var bodyHtml = '';
            for ( var i = 0; i < result.items.length; i++ ) {
                var item = result.items[i];
                bodyHtml += '<tr>';
                for ( var k = 0; k < opts.fields.length; k++ ) {
                    var field = opts.fields[k];
                    bodyHtml += '<td>' + item[field.name] + '</td>';
                }
                bodyHtml += '</tr>';
            }
            form.find( 'table tbody' ).html( bodyHtml );
            form.find( '.pagination .total' ).html( result.total );
            form.find( '.pagination .current' ).html( result.currentPage );
            form.find( '.pagination .pages' ).html( Math.max( Math.ceil( result.total / result.pageSize ), 1 ) );
        };

        form.on( 'submit', function() {
            $.ajax( {
                url: opts.sourceUrl,
                type: 'get',
                dataType: 'json',
                data: form.serializeArray(),
                success: function( response ) {
                    updateList( response );
                }
            } );
            return false;
        } );

        /**
         * Sort by specified field
         */
        form.find( '.field-name a' ).on( 'click', function() {
            var fieldName = $( this ).data( 'field' );
            var updated = false;
            for ( var i = 0; i < opts.sortings.length; i++ ) {
                if ( opts.sortings[i].field === fieldName ) {
                    form.find( 'input[name="sorting"]' ).val( fieldName + (opts.sortings[i].dir === 'ASC' ? ' DESC' : 'ASC') );
                    updated = true;
                    break;
                }
            }
            if ( !updated ) {
                form.find( 'input[name="sorting"]' ).val( fieldName + ' ASC' );
            }
            form.submit();
        } );

        /**
         * Build fixed header for the list
         */
        var tableHeader = table.find( '> thead' );
        var fixedHeader = $( '<div class="fixed-head"><table><thead>' + tableHeader.html() + '</thead></table></div>' );
        form.after( fixedHeader );
        var fixedTop = form.find( '.navigation' ).offset().top - parseInt( form.find( '.navigation' ).css( 'marginBottom' ) );
        $( document ).on( 'scroll', function() {
            if ( body.scrollTop() >= fixedTop ) {
                fixedHeader.show();
            } else {
                fixedHeader.hide();
            }
        } );

        /**
         * Sync value between table filter and fixed filter
         */
        var fixedInputs = fixedHeader.find( 'input, select' );
        var filterInputs = tableHeader.find( 'input, select' );
        fixedInputs.on( {
            input: function( evt ) {
                var el = $( evt.target );
                filterInputs.eq( fixedInputs.index( el ) ).val( el.val() );
            },
            change: function( evt ) {
                var el = $( evt.target );
                filterInputs.eq( fixedInputs.index( el ) ).val( el.val() );
            },
            keyup: function( evt ) {
                if ( evt.key === 'Enter' ) {
                    form.submit();
                }
            }
        } );
        filterInputs.on( {
            input: function( evt ) {
                var el = $( evt.target );
                fixedInputs.eq( filterInputs.index( el ) ).val( el.val() );
            },
            change: function( evt ) {
                var el = $( evt.target );
                fixedInputs.eq( filterInputs.index( el ) ).val( el.val() );
            }
        } );

        form.submit();

    };

} );