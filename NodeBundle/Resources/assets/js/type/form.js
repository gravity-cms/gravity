define(['jquery', 'jqueryui', 'bootstrap', 'bootbox', 'cms/core/api'], function ($, ui, bs, bootbox, api) {

    $(document).ready(function () {
        $('form.api-save').on('submit', function (e) {
            e.stopPropagation();
            e.preventDefault();

            api.saveForm($(this));
            return false;
        });

        var $addTypeFieldButton = $('.field-type-add'),
            $typeFieldTable     = $('table.field-type > tbody'),
            typeFieldCount      = $typeFieldTable.children().length;

        $addTypeFieldButton.on('click', function (e) {
            var template = $addTypeFieldButton.data('prototype');
            template = template.replace(/__name__/g, typeFieldCount);
            ++typeFieldCount;

            var $template = $(template);
            $template.find('input[name*="[order]"]').val(typeFieldCount);

            $typeFieldTable.append($template);
            $typeFieldTable.sortable('refresh');
        });

        $typeFieldTable.on('click', '.field-type-remove', function(){
            var $btn = $(this);
            bootbox.dialog({
                title: "Delete field",
                message: "Please confirm you want to delete this field. This action cannot be undone.",
                closeButton: false,
                buttons: {
                    cancel: {
                        label: "Cancel",
                        className: "btn-default"
                    },
                    delete: {
                        label: "Delete Field",
                        className: "btn-danger",
                        callback: function() {
                            api.call($btn.attr('href'), {
                                type: 'DELETE',
                                success: function(ob){
                                    $btn.closest('tr').remove();
                                    bootbox.hideAll()
                                }
                            });
                            return false;
                        }
                    }
                },
                className: "bootbox-md"
            });

            return false;
        });

    });
});
