/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define(['jquery', 'translator', 'utility'], function ($, __, utility) {

    return function (options) {

        let opts = $.extend(true, {
            form: null,
            sourceUrl: null,
            fields: [],
            sortings: [],
            rowActions: {
                redirect: function (action) {
                    utility.loading(true);
                    let query = [];
                    if (action.params) {
                        for (let k in action.params) {
                            let param = action.params[k];
                            if (action.params[k].indexOf(':') === 0) {
                                param = action.item[action.params[k].substr(1)] || param;
                            }
                            query.push(k + '=' + encodeURIComponent(param));
                        }
                    }
                    window.location.href = action.url + (action.url.indexOf('?') === -1 ? '?' : '&') + query.join('&');
                },
                edit: function (action) {
                    utility.loading(true);
                    window.location.href = action.url + (action.url.indexOf('?') === -1 ? '?' : '&') + 'id=' + action.item.id;
                },
                delete: function (action) {
                    utility.loading(true);
                    $.ajax({
                        url: action.url,
                        data: {id: action.item.id},
                        success: function (response) {
                            if (response.success) {
                                form.submit();
                            } else {
                                alert(response.message);
                            }
                        },
                        complete: function () {
                            utility.loading(false);
                        }
                    });
                }
            }
        }, options);

        let body = $('html, body');
        let form = $(opts.form);
        let table = form.find('table');
        let toolbar = table.find('> thead');
        let toolbarInputs = toolbar.find('input, select');

        let updateFixedHeader = function () {
            fixedHeader.html('<table><thead>' + toolbar.html() + '</thead></table>');
            toolbarInputs.each(function () {
                let el = $(this);
                fixedHeader.find(el.data('selector')).val(el.val());
            });
        };

        let updateList = function (result) {
            let totalPages = Math.max(Math.ceil(result.total / result.pageSize), 1);

            let bodyHtml = '';
            if (result.items.length !== 0) {
                for (let i = 0; i < result.items.length; i++) {
                    let item = result.items[i];
                    bodyHtml += '<tr>';
                    for (let k = 0; k < opts.fields.length; k++) {
                        let field = opts.fields[k];
                        if (field.ids) {
                            bodyHtml += '<td class="ids"><input type="checkbox" name="id" value="' + item.id + '" /></td>';
                        } else if (field.actions) {
                            bodyHtml += '<td class="actions"><ul style="z-index:' + (result.items.length - i) + ';"><li><a class="toggler" href="javascript:;"><span>' + __('Action') + '</span></a><ul>';
                            for (let a = 0; a < field.actions.length; a++) {
                                let action = field.actions[a];
                                action.item = item;
                                bodyHtml += '<li><a class="action" href="javascript:;" data-action="' + utility.encodeAttr(JSON.stringify(action)) + '"><span>' + field.actions[a].label + '</span></a></li>';
                            }
                            bodyHtml += '</ul></li></ul></td>';
                        } else {
                            bodyHtml += '<td>' + item[field.name] + '</td>';
                        }
                    }
                    bodyHtml += '</tr>';
                }
            } else {
                bodyHtml = '<tr><td class="no-record" colspan="' + opts.fields.length + '">' + __('No matched record found.') + '</td></tr>';
            }

            let currentPageHtml = '<select name="p" class="toolbarInputs-pagination" data-selector=".toolbarInputs-pagination">';
            for (let p = 1; p <= totalPages; p++) {
                currentPageHtml += '<option value="' + p + '"' + (p === result.currentPage ? ' selected="selected"' : '') + '>' + p + '</option>';
            }
            currentPageHtml += '</select>';

            form.find('table tbody').html(bodyHtml);
            form.find('.pagination .total').html(result.total);
            form.find('.pagination .current').html(currentPageHtml);
            form.find('.pagination .pages').html(totalPages);

            updateFixedHeader();
        };

        /**
         * Build fixed header for the list
         */
        form.after('<div class="fixed-head"></div>');
        let fixedHeader = $('.fixed-head');
        let tableTop = table.offset().top;
        let fixedTop = $('.main').offset().top + parseInt($('.main').css('paddingTop'));
        $(document).on('scroll', function () {
            if (tableTop - body.scrollTop() < fixedTop) {
                fixedHeader.show();
            } else {
                fixedHeader.hide();
            }
        });

        /**
         * Sync value between table filter and fixed filter
         */
        fixedHeader.on('input', 'input, select', function (evt) {
            let el = $(evt.target);
            let toolbarEl = toolbar.find(el.data('selector'));
            toolbarEl.val(el.val());
            toolbarEl.get(0).checked = evt.target.checked;
        }).on('change', 'input, select', function (evt) {
            let el = $(evt.target);
            toolbar.find(el.data('selector')).val(el.val());
        }).on('keyup', 'input, select', function (evt) {
            if (evt.key === 'Enter') {
                form.submit();
            }
        });
        toolbarInputs.on({
            input: function (evt) {
                let el = $(evt.target);
                let fixedHeaderEl = fixedHeader.find(el.data('selector'));
                fixedHeaderEl.val(el.val());
                fixedHeaderEl.get(0).checked = evt.target.checked;
            },
            change: function (evt) {
                let el = $(evt.target);
                fixedHeader.find(el.data('selector')).val(el.val());
            }
        });

        /**
         * Select all
         */
        fixedHeader.on('input', 'input.input-ids', function (evt) {
            form.find('tbody .ids input').each(function (i, el) {
                el.checked = evt.target.checked;
            });
        });
        toolbar.find('input.input-ids').on('input', function (evt) {
            form.find('tbody .ids input').each(function (i, el) {
                el.checked = evt.target.checked;
            });
        });

        /**
         * Actions of select in the toolbar
         */
        form.find('[name="limit"]').on('change', function () {
            form.find('[name="p"]').val(1);
            form.submit();
        });
        form.on('change', '[name="p"]', function () {
            form.submit();
        });
        fixedHeader.on('change', '[name="limit"]', function () {
            form.find('[name="p"]').val(1);
            form.submit();
        });
        fixedHeader.on('change', '[name="p"]', function () {
            form.submit();
        });

        form.on('click', 'tbody tr', function (evt) {
            let el = $(this).find('.ids input').get(0);
            if (el && evt.target !== el) {
                el.checked = !el.checked;
            }
        });

        /**
         * Actions of each line in the list
         */
        form.on('click', 'tbody .actions a.action', function () {
            let el = $(this);
            let action = el.data('action');
            if (action.confirm && !confirm(action.confirm)) {
                return;
            }
            if (typeof (opts.rowActions[action.name]) === 'function') {
                opts.rowActions[action.name](action);
            }
        });

        /**
         * Sort by specified field
         */
        let sortOrder = function () {
            let el = $(this), fieldName = el.data('field'), updated = false, dirCyc = ['', 'asc', 'desc'], dir;
            for (let i = 0; i < dirCyc.length; i++) {
                el.removeClass(dirCyc[i]);
            }
            for (let i = 0; i < opts.sortings.length; i++) {
                if (opts.sortings[i].field === fieldName) {
                    dir = (opts.sortings[i].dir === 'asc' ? 'desc' : 'asc');
                    form.find('input[name="sorting"]').val(fieldName + ',' + dir);
                    opts.sortings[i].dir = dir;
                    updated = true;
                    break;
                }
            }
            if (!updated) {
                dir = 'asc';
                form.find('input[name="sorting"]').val(fieldName + ',' + dir);
                opts.sortings.unshift({field: fieldName, dir: dir});
            }
            el.addClass(dir);
            form.submit();
        };
        form.find('.field-name a').on('click', sortOrder);
        fixedHeader.on('click', '.field-name a', sortOrder);

        form.on('submit', function () {
            utility.loading(true);
            $.ajax({
                url: opts.sourceUrl,
                type: 'get',
                dataType: 'json',
                data: form.serializeArray(),
                success: function (response) {
                    if (response.error) {
                        alert(response.message);
                        response.items = [];
                        response.total = 0;
                        response.pageSize = form.find('[name="limit"]').val();
                    }
                    updateList(response);
                },
                complete: function () {
                    utility.loading(false);
                }
            });
            return false;
        });
        form.submit();

    };

});