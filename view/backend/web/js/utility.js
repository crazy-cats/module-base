/* 
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define(['jquery'], function ($) {

    let self = {

        actButton: function (options) {

            let opts = $.extend(true, {
                wrapper: null,
                actions: {
                    massDelete: function (params) {
                        self.loading(true);
                        let form = $(params.target);
                        let ids = [];
                        form.find('.ids input:checked').each(function () {
                            ids.push(this.value);
                        });
                        $.ajax({
                            url: params.action,
                            type: 'post',
                            dataType: 'json',
                            data: {ids: ids},
                            success: function (response) {
                                if (response.success) {
                                    form.submit();
                                } else {
                                    alert(response.message);
                                }
                            },
                            complete: function () {
                                self.loading(false);
                            }
                        });
                    },
                    redirect: function (params) {
                        self.loading(true);
                        window.location.href = params.url;
                    },
                    save: function (params) {
                        self.loading(true);
                        $(params.target).append('<input type="hidden" name="to_list" value="1" />').submit();
                    },
                    saveContinue: function (params) {
                        self.loading(true);
                        $(params.target).submit();
                    }
                }
            }, options);

            $(opts.wrapper).find('button').each(function () {
                let button = $(this);
                if (opts.actions[button.data('action').type]) {
                    button.on('click', function () {
                        let action = button.data('action');
                        if (action.confirm && !confirm(action.confirm)) {
                            return;
                        }
                        opts.actions[action.type](action.params);
                    });
                }
            });

        },

        encodeAttr: function (str) {
            return str.replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&apos;');
        },

        loading: function (flag) {
            if (flag) {
                if ($('body > .loader').length === 0) {
                    $('body').append('<div class="loader"></div>');
                }
                $('body > .loader').show();
            } else {
                $('body > .loader').hide();
            }
        }

    };

    return self;

});