define(['jquery', 'jqueryui', 'bootstrap', 'cms/core/api'], function ($, ui, bs, api) {

    $(document).ready(function () {

        var $layoutForm = $('form.api-save');
        $layoutForm.on('submit', function(){
            api.saveForm($(this));
            return false;
        });

    });
});
