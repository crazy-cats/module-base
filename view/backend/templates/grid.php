<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Index\Block\Backend\AbstractGrid */
$fields = $this->getFields();
$filters = $this->getFilters();
$sorting = $this->getSorting();
$sourceUrl = $this->getSourceUrl();
?>
<div class="list">
    <div class="header">
        <form id="filter-form" method="get" action="<?php echo getUrl( $sourceUrl ) ?>">
            <?php foreach ( $fields as $field ) : ?>
                <div class="field">
                    <div class="field-name">
                        <?php if ( !empty( $field['sort'] ) ) : ?>
                            <a href="javascript:;" data-sorting="<?php echo (!empty( $sorting[$field['name']] ) ) ? $sorting[$field['name']] : null ?>">
                                <span><?php echo htmlEscape( $field['label'] ) ?></span>
                            </a>
                        <?php else : ?>
                            <span><?php echo htmlEscape( $field['label'] ) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="field-filter">
                        <?php
                        switch ( $field['filter'] ) :

                            case 'text' :
                                ?>
                                <input type="text" name="filter[<?php echo $field['name'] ?>]" value="<?php echo htmlEscape( empty( $filters[$field['name']] ) ? '' : $filters[$field['name']]  ) ?>" />
                                <?php
                                break;

                            case 'select' :
                                ?>
                                <select name="filter[<?php echo $field['name'] ?>]">
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
                    </div>
                </div>
            <?php endforeach; ?>
        </form>
    </div>
    <div class="body"></div>
    <div class="footer"></div>
</div>

<script type="text/javascript">
    // <!CDATA[
    require( [ 'jquery' ], function( $ ) {

        var sourceUrl = '<?php echo $sourceUrl ?>';
        var form = $( '#filter-form' );

        form.on( 'submit', function() {
            $.ajax( {
                url: sourceUrl,
                type: 'get',
                dataType: 'json',
                success: function( response ) {
                    console.log( response );
                }
            } );
            return false;
        } );

        form.find( '.field-name a' ).on( 'click', function( e ) {
            console.log( $( e.target ).data( 'sorting' ) );
            form.submit();
        } );

    } );
    // ]]>
</script>