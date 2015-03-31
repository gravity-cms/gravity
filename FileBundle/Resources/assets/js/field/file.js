define(['jquery', 'jqueryui', 'bootbox', 'cms/node/node/form', 'cms/file/browser/browser'], function ($, ui, bootbox, nodeForm, browser) {

    nodeForm.registerWidget('file', function($scope){
        var $launchButton = $scope.find('.launch-file-browser-button'),
            $fieldContainer = $scope.find('.file-fields'),
            fileTemplate = $launchButton.data('prototype'),
            browserTemplate = $launchButton.data('browser'),
            fieldCount = 0;

        $scope.find('.launch-file-browser-button').on('click', function(){

            bootbox.dialog({
                title: 'File Browser',
                message: browserTemplate,
                className: 'modal-full',
                buttons: {
                    cancel: {
                        label: 'Cancel'
                    }
                }
            });

            browser.attach(document);
            browser.addListener(browser.events.SELECT, function(data){
                for(var i in data){
                    $fieldContainer.append('<img src="'+data[i].url+'" class="img" />')
                }
                console.log(data);
            });

            fieldCount++;
            $fieldContainer.append(fileTemplate);
        });
    });

});
