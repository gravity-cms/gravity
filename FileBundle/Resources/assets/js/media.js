
define(['jquery', 'jqueryui', 'bootstrap', 'dropzone', 'typeahead', 'cms_api', 'cms_file_dropzone', 'cms_file_treebrowser'], function ($, jui, bs, Dropzone, typeahead, api, mDz, mTree) {

    // setup dropzone
    Dropzone.autoDiscover = false;

    var $form;
    var $dropzone;
    var carrosselDropZone;

    $(document).ready(function(){
        $form = $('form[name="linestorm_cms_form_file"],form[name="linestorm_cms_form_file_category"]');
        $dropzone = $('.dropzone');

        var formCount = parseInt($form.data('count')) || 0;

        var $tree = $('.file-browser');
        var tree = mTree.fileTree($tree);

        if($dropzone.length){
            var dz = mDz.dropzone($dropzone, {
                max: 0
            });

            dz.on('success', function(file, response) {
                if($form.data('category-id')){
                    $form.find('.file-form-category').val($form.data('category-id'));
                } else {
                    var selected = tree.tree.jstree('get_selected',true);
                    if(selected.length){
                        $form.find('.file-form-category').val(selected[0].original.node.id);
                    }
                }
            });
        }


        $('form[name="linestorm_cms_form_file_multiple"]').on('submit', function(e){
            e.preventDefault();
            e.stopPropagation();

            var $form = $(this),
                $fileItems = $form.find('.file-tile');
            api.saveForm($form)
                .success(function(on, status, xhr){
                    $fileItems.remove();
                })
                .fail(function(e, status, ex){
                    if(e.status === 400){
                        if(e.responseJSON){
                        } else {
                            alert(status);
                        }
                    }
                })
            ;

            return false;
        });

        $('form.file-api-save').on('submit', function(e){
            e.preventDefault();
            e.stopPropagation();

            api.saveForm($(this));
            return false;
        });

        $('.file-form-delete').on('click', function(){
            if(confirm("Are you sure you want to permanently delete this file?\n\nWARNING: IF IT IS USED ANYWHERE, IT WILL CREATE 404 RESPONSES")){
                api.call($(this).data('url'), {
                    type: 'DELETE',
                    success: function(o){
                        alert(o.message);
                        window.location = o.location;
                    }
                });
            }
        });

        $('.file-form-child-delete').on('click', function(){
            var $fileChildRow = $(this).closest('tr.file-child-row');
            if(confirm("Are you sure you want to permanently delete this file?\n\nWARNING: IF IT IS USED ANYWHERE, IT WILL CREATE 404 RESPONSES")){
                api.call($(this).data('url'), {
                    type: 'DELETE',
                    success: function(o){
                        $fileChildRow.remove();
                    }
                });
            }
        });

        $('.file-children-regenerate').on('click', function(){
            var $fileChildRow = $(this).closest('tr.file-child-row');
            if(confirm("Are you sure you want to regenerate all resized file?")){
                api.call($(this).data('url'), {
                    type: 'PATCH',
                    success: function(o){
                        window.location.reload();
                    }
                });
            }
        });

    });

});
