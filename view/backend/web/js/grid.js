/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery', 'CrazyCat/Index/js/utility' ], function( $, utility ) {

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
                edit: function( action ) {
                    window.location.href = action.url + (action.url.indexOf( '?' ) === -1 ? '?' : '&') + 'id=' + action.item.id;
                },
                delete: function( action ) {
                    utility.loading( true );
                    $.ajax( {
                        url: action.url,
                        data: {id: action.item.id},
                        success: function( response ) {
                            if ( response.success ) {
                                form.submit();
                            }
                        },
                        complete: function() {
                            utility.loading( false );
                        }
                    } );
                }
            }
        }, options );

        var body = $( 'html, body' );
        var form = $( opts.form );
        var table = form.find( 'table' );
        var toolbar = table.find( '> thead' );
        var toolbarInputs = toolbar.find( 'input, select' );

        var updateFixedHeader = function() {
            fixedHeader.html( '<table><thead>' + toolbar.html() + '</thead></table>' );
            toolbarInputs.each( function() {
                var el = $( this );
                fixedHeader.find( el.data( 'selector' ) ).val( el.val() );
            } );
        };

        var updateList = function( result ) {
            var totalPages = Math.max( Math.ceil( result.total / result.pageSize ), 1 );

            var bodyHtml = '';
            if ( result.items.length !== 0 ) {
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
                                bodyHtml += '<option value="' + utility.encodeAttr( JSON.stringify( action ) ) + '">' + field.actions[a].label + '</option>';
                            }
                            bodyHtml += '</select></td>';
                        } else {
                            bodyHtml += '<td>' + item[field.name] + '</td>';
                        }
                    }
                    bodyHtml += '</tr>';
                }
            } else {
                bodyHtml = '<tr><td class="no-record" colspan="' + opts.fields.length + '">' + 'No matched record found.' + '</td></tr>';
            }

            var currentPageHtml = '<select name="p" class="toolbarInputs-pagination" data-selector=".toolbarInputs-pagination">';
            for ( var p = 1; p <= totalPages; p++ ) {
                currentPageHtml += '<option value="' + p + '"' + (p === result.currentPage ? ' selected="selected"' : '') + '>' + p + '</option>';
            }
            currentPageHtml += '</select>';

            form.find( 'table tbody' ).html( bodyHtml );
            form.find( '.pagination .total' ).html( result.total );
            form.find( '.pagination .current' ).html( currentPageHtml );
            form.find( '.pagination .pages' ).html( totalPages );

            updateFixedHeader();
        };

        /**
         * Build fixed header for the list
         */
        form.after( '<div class="fixed-head"></div>' );
        var fixedHeader = $( '.fixed-head' );
        var tableTop = table.offset().top;
        var fixedTop = $( '.main' ).offset().top + parseInt( $( '.main' ).css( 'paddingTop' ) );
        $( document ).on( 'scroll', function() {
            if ( tableTop - body.scrollTop() <= fixedTop ) {
                fixedHeader.show();
            } else {
                fixedHeader.hide();
            }
        } );

        /**
         * Sync value between table filter and fixed filter
         */
        fixedHeader.on( 'input', 'input, select', function( evt ) {
            var el = $( evt.target );
            toolbar.find( el.data( 'selector' ) ).val( el.val() );
        } ).on( 'change', 'input, select', function( evt ) {
            var el = $( evt.target );
            toolbar.find( el.data( 'selector' ) ).val( el.val() );
        } ).on( 'keyup', 'input, select', function( evt ) {
            if ( evt.key === 'Enter' ) {
                form.submit();
            }
        } );
        toolbarInputs.on( {
            input: function( evt ) {
                var el = $( evt.target );
                fixedHeader.find( el.data( 'selector' ) ).val( el.val() );
            },
            change: function( evt ) {
                var el = $( evt.target );
                fixedHeader.find( el.data( 'selector' ) ).val( el.val() );
            }
        } );

        form.find( '[name="limit"]' ).on( 'change', function() {
            form.find( '[name="p"]' ).val( 1 );
            form.submit();
        } );
        form.on( 'change', '[name="p"]', function() {
            form.submit();
        } );
        
        fixedHeader.on( 'change', '[name="limit"]', function() {
            form.find( '[name="p"]' ).val( 1 );
            form.submit();
        } );
        fixedHeader.on( 'change', '[name="p"]', function() {
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
            utility.loading( true );
            $.ajax( {
                url: opts.sourceUrl,
                type: 'get',
                dataType: 'json',
                data: form.serializeArray(),
                success: function( response ) {
                    updateList( response );
                },
                complete: function() {
                    utility.loading( false );
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

        form.submit();

    };

} );