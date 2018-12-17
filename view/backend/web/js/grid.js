/* 
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define( [ 'jquery', 'utility' ], function( $, utility ) {

    return function( options ) {

        var opts = $.extend( true, {
            form: null,
            sourceUrl: null,
            fields: [ ],
            sortings: [ ],
            rowActions: {
                view: function( action ) {
                    utility.loading( true );
                    window.location.href = action.url + (action.url.indexOf( '?' ) === -1 ? '?' : '&') + 'id=' + action.item.id;
                },
                edit: function( action ) {
                    utility.loading( true );
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
                            } else {
                                alert( response.message );
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
                        if ( field.ids ) {
                            bodyHtml += '<td class="ids"><input type="checkbox" name="id" value="' + item.id + '" /></td>';
                        } else if ( field.actions ) {
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
            if ( tableTop - body.scrollTop() < fixedTop ) {
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
            var toolbarEl = toolbar.find( el.data( 'selector' ) );
            toolbarEl.val( el.val() );
            toolbarEl.get( 0 ).checked = evt.target.checked;
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
                var fixedHeaderEl = fixedHeader.find( el.data( 'selector' ) );
                fixedHeaderEl.val( el.val() );
                fixedHeaderEl.get( 0 ).checked = evt.target.checked;
            },
            change: function( evt ) {
                var el = $( evt.target );
                fixedHeader.find( el.data( 'selector' ) ).val( el.val() );
            }
        } );

        /**
         * Select all
         */
        fixedHeader.on( 'input', 'input.input-ids', function( evt ) {
            form.find( 'tbody .ids input' ).each( function( i, el ) {
                el.checked = evt.target.checked;
            } );
        } );
        toolbar.find( 'input.input-ids' ).on( 'input', function( evt ) {
            form.find( 'tbody .ids input' ).each( function( i, el ) {
                el.checked = evt.target.checked;
            } );
        } );

        /**
         * Actions of select in the toolbar
         */
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

        form.on( 'click', 'tbody tr', function( evt ) {
            var el = $( this ).find( '.ids input' ).get( 0 );
            if ( el && evt.target !== el ) {
                el.checked = !el.checked;
            }
        } );

        /**
         * Actions of each line in the list
         */
        form.on( 'change', 'tbody .actions select', function() {
            var el = $( this );
            if ( !el.val() ) {
                return;
            }
            var action = JSON.parse( el.val() );
            if ( action.confirm && !confirm( action.confirm ) ) {
                return;
            }
            if ( typeof (opts.rowActions[action.name]) === 'function' ) {
                opts.rowActions[action.name]( action );
            }
        } );

        /**
         * Sort by specified field
         */
        var sortOrder = function() {
            var el = $( this ), fieldName = el.data( 'field' ), updated = false, dirCyc = [ '', 'asc', 'desc' ], dir;
            for ( var i = 0; i < dirCyc.length; i++ ) {
                el.removeClass( dirCyc[i] );
            }
            for ( var i = 0; i < opts.sortings.length; i++ ) {
                if ( opts.sortings[i].field === fieldName ) {
                    dir = (opts.sortings[i].dir === 'asc' ? 'desc' : 'asc');
                    form.find( 'input[name="sorting"]' ).val( fieldName + ',' + dir );
                    opts.sortings[i].dir = dir;
                    updated = true;
                    break;
                }
            }
            if ( !updated ) {
                dir = 'asc';
                form.find( 'input[name="sorting"]' ).val( fieldName + ',' + dir );
                opts.sortings.unshift( {field: fieldName, dir: dir} );
            }
            el.addClass( dir );
            form.submit();
        };
        form.find( '.field-name a' ).on( 'click', sortOrder );
        fixedHeader.on( 'click', '.field-name a', sortOrder );

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
        form.submit();

    };

} );