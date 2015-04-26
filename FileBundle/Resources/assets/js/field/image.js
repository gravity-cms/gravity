define(['jquery', 'jqueryui', 'bootbox', 'cms/node/node/form', 'cms/file/browser/browser'], function ($, ui, bootbox, nodeForm, browserFactory) {

    nodeForm.registerWidget('image', function($scope){

        $scope.find('.file-browser-widget').each(function(){
            var $field = $(this),
                $launchButton = $field.find('.launch-file-browser-button'),
                previewStyle = $launchButton.data('preview-style'),
                browserTemplate = $launchButton.data('browser'),
                $entityInput = $field.find('input[type="hidden"]');

            var box = $(browserTemplate);
            var browser = browserFactory.create(box);
            browser.addListener(browserFactory.EVENTS.SELECT, function(data){
                for(var i in data){
                    $entityInput.val(data[i].id);
                    $field.find('.field-image-img').attr('src', data[i].styles[previewStyle]);
                    $field.find('.field-image-title').text(data[i].name);
                }
                box.modal('hide');
            });

            box.modal({
                show: false
            });
            $scope.find('.launch-file-browser-button').on('click', function(){
                box.modal('show');
            });

            //$fieldContainer.on('click', '.file-item-remove', function(){
            //    $(this).closest('.file-item').remove();
            //})
        });
    });

});
