/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */
define([], function () {

    return function (string, params) {
        params = params || [];
        let translations = window.localStorage.getItem(window.translationStorageName);
        translations = translations ? JSON.parse(translations) : {};
        let translatedText = translations[string] || string;
        for (let k = 0; k < params.length; k++) {
            translatedText = translatedText.replace('%' + (k + 1), params[k]);
        }
        return translatedText;
    };

});