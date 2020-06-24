/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define(['jquery', 'utility', 'editor', 'CrazyCat/Base/js/validation'], function ($, utility, editor) {

    return function (options) {

        let opts = $.extend(true, {
            el: null,
            fields: [],
            editor: {
                baseUrl: null,
                imageUploadUrl: null,
                skinUrl: null,
                height: 400
            },
            validation: {
                rules: {},
                invalidHandler: function () {
                    utility.loading(false);
                }
            }
        }, options);

        let form = $(opts.el);

        let multiValueTypes = ['multiselect'];
        for (let groupName in opts.fields) {
            let fields = opts.fields[groupName].fields;
            for (let i = 0; i < fields.length; i++) {
                if (fields[i].type === 'editor') {
                    editor.init({
                        selector: '#data_' + fields[i].name,
                        height: fields[i].height || opts.editor.height,
                        theme: 'modern',
                        plugins: 'searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help code',
                        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | link image | removeformat code',
                        document_base_url: opts.editor.baseUrl,
                        images_upload_url: opts.editor.imageUploadUrl,
                        skin_url: opts.editor.skinUrl,
                        images_upload_credentials: true
                    });
                }
                if (fields[i].validation) {
                    let fieldName = multiValueTypes.indexOf(fields[i].type) ? ('data[' + fields[i].name + ']') : ('data[' + fields[i].name + '][]');
                    opts.validation.rules[fieldName] = fields[i].validation;
                }
            }
        }
        form.validate(opts.validation);

        form.find('.field-group-label').on('click', function () {
            $(this).siblings('.field-group-content').slideDown();
            $(this).closest('.field-group').siblings().find('.field-group-content').slideUp();
        }).eq(0).click();

    };

});