define(['jquery', 'jqueryui', 'bootstrap', 'cms/core/api'], function ($, ui, bs, api) {

    $(document).ready(function () {

        // Return a helper with preserved width of cells
        var fixHelper = function (e, ui) {
            ui.children().each(function () {
                $(this).width($(this).width());
            });
            return ui;
        };

        var $sortableContainers = $("table.layout-table tbody");
        $sortableContainers.each(function(){
            var $sortableContainer = $(this);
            var $placeholder = $(this).children('tr.placeholder');
            $sortableContainer.sortable({
                axis: 'y',
                helper: fixHelper,
                handle: '.drag-handle',
                connectWith: 'table.layout-table tbody',
                items: 'tr:not(.placeholder)',
                cancel: "tr.no-sort",
                dropOnEmpty: true,
                tolerance: "pointer",

                create: function (e, ui) {
                    if($(e.target).children(':not(.ui-sortable-helper, .ui-sortable-placeholder, .placeholder)').length > 0){
                        $placeholder.hide();
                    }
                },
                out: function (e, ui) {
                    if($(e.target).children(':not(.ui-sortable-helper, .ui-sortable-placeholder, .placeholder)').length <= 0){
                        $placeholder.show();
                    }
                },
                stop: function (e, ui) {
                    if($(e.target).children(':not(.ui-sortable-helper, .ui-sortable-placeholder, .placeholder)').length > 0){
                        $placeholder.hide();
                    }
                    ui.item.find('td').css('background-color', '#fbf7de');
                },
                update: function (e, ui) {
                    if($(e.target).children(':not(.ui-sortable-helper, .ui-sortable-placeholder, .placeholder)').length > 0){
                        $placeholder.hide();
                    }
                    $sortableContainer.find('tr').each(function (i, el) {
                        $(el).find('.table-sort-order input').val(i);
                    });
                }
            }).disableSelection().css('min-height', '100px');
        });

        var $layoutForm = $('form.api-save');
        $layoutForm.on('submit', function(){
            api.saveForm($(this));
            return false;
        });

        var $newBlockSelector = $('select.new-block-selector'),
            $newBlockButton = $('button.new-block-button');
        $newBlockButton.on('click', function(){
            window.location.href = $newBlockSelector.val();
        });
    });
});
