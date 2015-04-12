define(['jquery', 'cms/core/api'], function ($, api) {

    $(document).ready(function () {
        var $form = $('form.api-save');

        $form.on('submit', function (e) {
            e.stopPropagation();
            e.preventDefault();

            api.saveForm($(this));
            return false;
        });
    });
});
