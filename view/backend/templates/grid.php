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
$sortings = $this->getSortings();
$sourceUrl = $this->getSourceUrl();
?>
<div class="backend-grid">
    <form id="grid-form" method="get" action="<?php echo getUrl( $sourceUrl ) ?>">
        <div class="navigation-wrapper">
            <div class="navigation">
                <div class="page-limit">
                    <select name="limit">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span><?php echo __( 'items per page' ) ?></span>
                </div>
                <div class="pagination">
                    <?php echo __( 'Total %1 items, page %2 of %3', [ '<span class="total"></span>', '<span class="current"></span>', '<span class="pages"></span>' ] ) ?>
                </div>
                <div class="actions">
                    <button type="submit" class="button"><span><?php echo __( 'Search' ) ?></span></button>
                </div>
            </div>
        </div>
        <table>
            <thead>
                <tr class="field-name">
                    <?php foreach ( $fields as $field ) : ?>
                        <th<?php echo isset( $field['actions'] ) ? ' class="actions"' : '' ?>>
                            <?php
                            if ( !empty( $field['sort'] ) ) :
                                $sorting = $this->getSorting( $field['name'] );
                                ?>
                                <a href="javascript:;" data-field="<?php echo $field['name'] ?>"
                                   <?php $sorting ? ( 'class="' . strtolower( $sorting['dir'] ) . '"' ) : '' ?>>
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
                        <th<?php echo isset( $field['actions'] ) ? ' class="actions"' : '' ?>>
                            <?php
                            if ( isset( $field['actions'] ) ) {
                                echo '&nbsp;';
                                continue;
                            }
                            switch ( $field['filter']['type'] ) :

                                case AbstractGrid::FIELD_TYPE_TEXT :
                                    ?>
                                    <input type="text" class="input-text" name="filter[<?php echo $field['name'] ?>]" value="<?php echo htmlEscape( empty( $filters[$field['name']] ) ? '' : $filters[$field['name']]  ) ?>" />
                                    <?php
                                    break;

                                case AbstractGrid::FIELD_TYPE_SELECT :
                                    ?>
                                    <select name="filter[<?php echo $field['name'] ?>]">
                                        <option value="<?php echo StaticVariable::NO_SELECTION ?>"></option>
                                        <?php
                                        if ( !empty( $field['options'] ) ) :
                                            foreach ( $field['options'] as $option ) :
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
                    <td colspan="<?php echo count( $fields ) ?>">
                        <input type="hidden" name="sorting" value="" />
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<script type="text/javascript">
    // <!CDATA[
    require( [ 'CrazyCat/Index/js/grid' ], function( grid ) {
        grid( {
            form: '#grid-form',
            fields: <?php echo json_encode( $fields ); ?>,
            sortings: <?php echo json_encode( $sortings ); ?>,
            sourceUrl: '<?php echo $sourceUrl ?>'
        } );
    } );
    // ]]>
</script>