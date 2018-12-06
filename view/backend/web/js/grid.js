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
            sortings: [ ],
            actions: {
                view: function( action ) {
                    window.location.href = action.url + (action.url.indexOf( '?' ) === -1 ? '?' : '&') + 'id=' + action.item.id;
                },
                delete: function( action ) {
                    $.ajax( {
                        url: action.url,
                        data: {id: action.item.id},
                        success: function( response ) {
                            form.submit();
                        }
                    } );
                }
            }
        }, options );

        var form = $( opts.form );
        var table = form.find( 'table' );

        var encodeAttr = function( str ) {
            return str.replace( /&/g, '&amp;' )
                    .replace( /</g, '&lt;' )
                    .replace( />/g, '&gt;' )
                    .replace( /"/g, '&quot;' )
                    .replace( /'/g, '&apos;' );
        };

        var updateList = function( result ) {
            var totalPages = Math.max( Math.ceil( result.total / result.pageSize ), 1 );

            var bodyHtml = '';
            for ( var i = 0; i < result.items.length; i++ ) {
                var item = result.items[i];
                bodyHtml += '<tr>';
                for ( var k = 0; k < opts.fields.length; k++ ) {
                    var field = opts.fields[k];
                    if ( field.actions ) {
                        bodyHtml += '<td class="actions"><select><option></option>';
                        for ( var a = 0; a < field.actions.length; a++ ) {
                            var action = field.actions[a];
                            action.item = item;
                            bodyHtml += '<option value="' + encodeAttr( JSON.stringify( action ) ) + '">' + field.actions[a].label + '</option>';
                        }
                        bodyHtml += '</select></td>';
                    } else {
                        bodyHtml += '<td>' + item[field.name] + '</td>';
                    }
                }
                bodyHtml += '</tr>';
            }

            var currentPageHtml = '<select name="p">';
            for ( var p = 1; p <= totalPages; p++ ) {
                currentPageHtml += '<option value="' + p + '"' + (p === result.currentPage ? ' selected="selected"' : '') + '>' + p + '</option>';
            }
            currentPageHtml += '</select>';

            form.find( 'table tbody' ).html( bodyHtml );
            form.find( '.pagination .total' ).html( result.total );
            form.find( '.pagination .current' ).html( currentPageHtml );
            form.find( '.pagination .pages' ).html( totalPages );
        };

        form.find( '[name="limit"]' ).on( 'change', function() {
            form.find( '[name="p"]' ).val( 1 );
            form.submit();
        } );

        form.on( 'change', '[name="p"]', function() {
            form.submit();
        } );

        form.on( 'change', 'tbody .actions select', function() {
            var el = $( this );
            if ( !el.val() ) {
                return;
            }
            var action = JSON.parse( el.val() );
            if ( action.confirm && !confirm( action.confirm ) ) {
                return;
            }
            if ( typeof (opts.actions[action.name]) === 'function' ) {
                opts.actions[action.name]( action );
            }
        } );

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
                    var dir = (opts.sortings[i].dir === 'ASC' ? 'DESC' : 'ASC');
                    form.find( 'input[name="sorting"]' ).val( fieldName + ',' + dir );
                    opts.sortings[i].dir = dir;
                    updated = true;
                    break;
                }
            }
            if ( !updated ) {
                form.find( 'input[name="sorting"]' ).val( fieldName + ',ASC' );
                opts.sortings.unshift( {field: fieldName, dir: 'ASC'} );
            }
            form.submit();
        } );

        /**
         * Build fixed header for the list
         */
        var tableHeader = table.find( '> thead' );
        var fixedHeader = $( '<div class="fixed-head"><table><thead>' + tableHeader.html() + '</thead></table></div>' );
        form.after( fixedHeader );

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