define(['jquery', 'jqueryui', 'bootstrap', 'bootbox', 'cms/core/api'], function ($, ui, bs, bootbox, api) {

    $(document).ready(function () {

        var $form = $('form.api-save');

        $form.on('submit', function (e) {
            e.stopPropagation();
            e.preventDefault();

            api.saveForm($(this));
            return false;
        });

        $form.on('click', '.api-delete', function(){
            var a = this;
            bootbox.dialog({
                title: 'Delete node',
                message: 'Are you sure you want to remove this tag?',
                buttons: {
                    cancel: {
                        label: 'Cancel'
                    },
                    delete: {
                        label: "Delete Tag",
                        className: "btn-danger",
                        callback: function() {
                            api.call(a.href, {
                                method: 'DELETE',
                                success:function(o){
                                    bootbox.alert('The tag has been removed.', function(){

                                    });
                                }
                            });
                        }
                    }
                }
            });

            return false;
        });
    });
});
