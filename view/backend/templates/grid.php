<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

use CrazyCat\Framework\App\Module\Block\Backend\AbstractGrid;
use CrazyCat\Framework\Utility\StaticVariable;

/* @var $this \CrazyCat\Framework\App\Module\Block\Backend\AbstractGrid */
$fields = $this->getFields();
$filters = $this->getFilters();
$sorting = $this->getSorting();
$sourceUrl = $this->getSourceUrl();
?>
<div class="list">
    <form id="list-form" method="get" action="<?php echo getUrl( $sourceUrl ) ?>">
        <div class="navigation">
            <div class="pagination">
                <?php echo __( 'Total %1 items, page %2 of %3', [ '<span class="total"></span>', '<span class="current"></span>', '<span class="pages"></span>' ] ) ?>
            </div>
            <div class="actions">
                <button type="submit" class="button"><span><?php echo __( 'Search' ) ?></span></button>
            </div>
        </div>
        <table>
            <thead>
                <tr class="field-name">
                    <?php foreach ( $fields as $field ) : ?>
                        <th>
                            <?php if ( !empty( $field['sort'] ) ) : ?>
                                <a href="javascript:;" data-sorting="<?php echo (!empty( $sorting[$field['name']] ) ) ? $sorting[$field['name']] : null ?>">
                                    <span><?php echo htmlEscape( $field['label'] ) ?></span>
                                </a>
                            <?php else : ?>
                                <span><?php echo htmlEscape( $field['label'] ) ?></span>
                            <?php endif; ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
                <tr class="field-filter">
                    <?php foreach ( $fields as $field ) : ?>
                        <th>
                            <?php
                            switch ( $field['filter']['type'] ) :

                                case AbstractGrid::FIELD_TYPE_TEXT :
                                    ?>
                                    <input type="text" class="input-box" name="filter[<?php echo $field['name'] ?>]" value="<?php echo htmlEscape( empty( $filters[$field['name']] ) ? '' : $filters[$field['name']]  ) ?>" />
                                    <?php
                                    break;

                                case AbstractGrid::FIELD_TYPE_SELECT :
                                    ?>
                                    <select name="filter[<?php echo $field['name'] ?>]">
                                        <option value="<?php echo StaticVariable::NO_SELECTION ?>"></option>
                                        <?php
                                        if ( !empty( $field['filter_options'] ) ) :
                                            foreach ( $field['filter_options'] as $option ) :
                                                ?>
                                                <option value="<?php echo htmlEscape( $option['value'] ) ?>"
                                                        <?php echo ( isset( $filters[$field['name']] ) && $filters[$field['name']] === $option['value'] ) ? 'selected="selected"' : '' ?>>
                                                            <?php echo htmlEscape( $option['label'] ) ?>
                                                </option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <?php
                                    break;

                            endswitch;
                            ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="<?php echo count( $fields ) ?>">&nbsp;</td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<script type="text/javascript">
    // <!CDATA[
    require( [ 'jquery' ], function( $ ) {

        var sourceUrl = '<?php echo $sourceUrl ?>';
        var fields = <?php echo json_encode( $fields ); ?>;
        var body = $( 'html,body' );
        var form = $( '#list-form' );
        var table = form.find( 'table' );

        var updateList = function( result ) {
            var bodyHtml = '';
            for ( var i = 0; i < result.items.length; i++ ) {
                var item = result.items[i];
                bodyHtml += '<tr>';
                for ( var k = 0; k < fields.length; k++ ) {
                    var field = fields[k];
                    bodyHtml += '<td>' + item[field.name] + '</td>';
                }
                bodyHtml += '</tr>';
            }
            form.find( 'table tbody' ).html( bodyHtml );
            form.find( '.pagination .total' ).html( result.total );
            form.find( '.pagination .current' ).html( result.currentPage );
            form.find( '.pagination .pages' ).html( Math.ceil( result.total / result.pageSize ) );
        };

        form.on( 'submit', function() {
            $.ajax( {
                url: sourceUrl,
                type: 'get',
                dataType: 'json',
                data: form.serializeArray(),
                success: function( response ) {
                    updateList( response );
                }
            } );
            return false;
        } );

        form.find( '.field-name a' ).on( 'click', function( e ) {
            console.log( $( e.target ).data( 'sorting' ) );
            form.submit();
        } );

        form.submit();

        var tableHeader = table.find( '> thead' );
        var fixedHeader = $( '<div class="fixed-head"><table><thead>' + tableHeader.html() + '</thead></table></div>' );
        form.after( fixedHeader );

        // sync value of filter
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

        var fixedTop = form.find( '.navigation' ).offset().top - parseInt( form.find( '.navigation' ).css( 'marginBottom' ) );
        $( document ).on( 'scroll', function() {
            if ( body.scrollTop() >= fixedTop ) {
                fixedHeader.show();
            } else {
                fixedHeader.hide();
            }
        } );

    } );
    // ]]>
</script>