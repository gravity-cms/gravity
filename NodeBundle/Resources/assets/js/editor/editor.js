define(['jquery'], function ($) {

    var editors = {};

    return {
        registerEditor: function (name, callback) {
            editors[name] = callback;
            callback($(document));
        },
        bindEditor: function (name, $editor) {
            var callback = editors[name];
            if(callback) {
                callback($editor);
            }
        }
    };

});
