define(['jquery', 'jqueryui', 'bootstrap', 'bootbox', 'cms/core/api'], function ($, ui, bs, bootbox, api) {

    $(document).ready(function () {

        var $deleteContentTypeButtons = $('a.content-type-delete');

        $deleteContentTypeButtons.on('click', function (e) {
            var deleteBtn = this;
            bootbox.dialog({
                title: "Delete Content Field",
                message: "<div class='form-group'>Are you sure you want to delete this Content Type?</div>" +
                         "<div class='form-group'>Deleting this Content Type will remove all Field and" +
                         " Nodes associated with this Content Type</div>" +
                         "<div class='form-group'>" +
                         "<input class='form-control input-delete-confirm' autocomplete='off' placeholder='Enter \"DELETE\" to continue' />" +
                         "<p class='help-block'>To delete this Content Type, enter &quot;DELETE&quot; and press delete:</p></div>",
                closeButton: false,
                buttons: {
                    cancel: {
                        label: "Cancel",
                        className: "btn-default"
                    },
                    delete: {
                        label: "Delete Content Type",
                        className: "btn-danger",
                        callback: function(e) {
                            var $box = $(e.delegateTarget).find('.form-group'),
                                $input = $box.find('.input-delete-confirm'),
                                $buttons = $(e.target).parent().children('button');
                            if($input.val().toUpperCase() === 'DELETE'){
                                $buttons.attr('disabled', true);
                                api.call(deleteBtn.href, {
                                    type: 'DELETE',
                                    success: function(ob){
                                        $buttons.attr('disabled', false);
                                        $(deleteBtn).closest('tr').remove();
                                        bootbox.hideAll();
                                    },
                                    error: function(){
                                        $buttons.attr('disabled', false);
                                    }
                                });
                            } else {
                                $box.addClass('has-error');
                                $input.focus();
                            }
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
