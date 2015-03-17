define(['jquery', 'jqueryui', 'bootstrap', 'bootbox', 'cms/core/api'], function ($, ui, bs, bootbox, api) {

    $(document).ready(function () {

        // Return a helper with preserved width of cells
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };

        var $sortableContainer = $("table.content-type-form-view tbody");
        $sortableContainer.sortable({
            axis: 'y',
            helper: fixHelper,
            handle: '.drag-handle',
            cancel: '',
            stop: function(e, ui){
                ui.item.find('td').css('background-color', '#fbf7de');
            },
            update: function(e, ui){
                $sortableContainer.find('tr').each(function(i,el){
                    $(el).find('.table-sort-order input').val(i);
                });
            }
        }).disableSelection();

    });
});
