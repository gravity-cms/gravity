define(['jquery', 'jqueryui', 'bootbox', 'cms/node/node/form', 'cms/file/browser/browser'], function ($, ui, bootbox, nodeForm, browserFactory) {

    nodeForm.registerWidget('image', function($scope){

        $scope.find('.file-browser-widget').each(function(){
            var $field = $(this),
                $launchButton = $field.find('.launch-image-browser-button'),
                previewStyle = $launchButton.data('preview-style'),
                box = $field.find('.file-browser-modal'),
                $browser = $field.find('.file-browser'),
                $entityInput = $field.find('input[type="hidden"]');


            var browser = browserFactory.create($browser, $browser.data());

            browser.addListener(browserFactory.EVENTS.SELECT, function(data){
                for(var i in data){
                    $entityInput.val(data[i].id);
                    $field.find('.field-image-img').attr('src', data[i].styles[previewStyle]);
                    $field.find('.field-image-title').text(data[i].name);
                }
                box.modal('hide');
            });


            $launchButton.on('click', function(){
                box.modal({
                    show: true
                });
            });

            //$fieldContainer.on('click', '.file-item-remove', function(){
            //    $(this).closest('.file-item').remove();
            //})
        });
    });

});
