<?php
/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Base\Block\Backend\AbstractGrid */
$fields = $this->getFields();
$sortings = $this->getSortings();
$sourceUrl = $this->getSourceUrl();
?>
<div class="backend-grid">
    <form id="grid-form" method="get" action="<?php echo $sourceUrl ?>">
        <table>
            <thead>
            <tr>
                <th class="navigation-wrapper" colspan="<?php echo count($fields) ?>">
                    <div class="navigation">
                        <div class="page-limit">
                            <select name="limit" class="toolbar-page-limit" data-selector=".toolbar-page-limit">
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span><?php echo __('items per page') ?></span>
                        </div>
                        <div class="pagination">
                            <?php echo __(
                                'Total %1 items, page %2 of %3',
                                [
                                    '<span class="total"></span>',
                                    '<span class="current"></span>',
                                    '<span class="pages"></span>'
                                ]
                            ) ?>
                        </div>
                        <div class="actions">
                            <button type="submit" class="button"><span><?php echo __('Search') ?></span></button>
                        </div>
                    </div>
                </th>
            </tr>
            <tr class="field-name">
                <?php foreach ($fields as $field) : ?>
                    <th class="<?= isset($field['actions']) ? 'actions' : (isset($field['ids']) ? 'ids' : 'item') ?>"
                        <?= isset($field['width']) ? sprintf(
                            ' style="width:%d%s;"',
                            $field['width'],
                            strpos($field['width'], '%') !== false ? '%' : 'px'
                        ) : ''; ?>
                    >
                        <?php if (!empty($field['ids'])) : ?>
                            &nbsp;&nbsp;
                        <?php elseif (!empty($field['sort'])) :
                            $sorting = $this->getSorting($field['name']);
                            ?>
                            <a href="javascript:;" data-field="<?php echo $field['name'] ?>"
                                <?php echo $sorting ? ('class="' . strtolower($sorting['dir']) . '"') : '' ?>>
                                <span><?php echo htmlEscape($field['label']) ?></span>
                            </a>
                        <?php else : ?>
                            <span><?php echo htmlEscape($field['label']) ?></span>
                        <?php endif; ?>
                    </th>
                <?php endforeach; ?>
            </tr>
            <tr class="field-filter">
                <?php foreach ($fields as $field) : ?>
                    <th class="<?php echo isset($field['actions']) ? 'actions' : (isset($field['ids']) ? 'ids' : 'item') ?>">
                        <?php echo $this->renderFilter($field); ?>
                    </th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
            <tr>
                <td colspan="<?php echo count($fields) ?>">
                    <input type="hidden" name="sorting" value=""/>
                    <input type="hidden" name="ajax" value="1"/>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>

<script type="text/javascript">
    // <!CDATA[
    require(['CrazyCat/Base/js/grid'], function (grid) {
        grid({
            form: '#grid-form',
            fields: <?php echo json_encode($fields); ?>,
            sortings: <?php echo json_encode($sortings); ?>,
            sourceUrl: '<?php echo $sourceUrl ?>'
        });
    });
    // ]]>
</script>