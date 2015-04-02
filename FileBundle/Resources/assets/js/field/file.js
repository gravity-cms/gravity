define(['jquery', 'jqueryui', 'bootbox', 'cms/node/node/form', 'cms/file/browser/browser'], function ($, ui, bootbox, nodeForm, browser) {

    nodeForm.registerWidget('file', function($scope){
        var $launchButton = $scope.find('.launch-file-browser-button'),
            $fieldContainer = $scope.find('.file-items'),
            fileTemplate = $launchButton.data('prototype'),
            browserTemplate = $launchButton.data('browser'),
            fieldCount = $fieldContainer.children().length;

        browser.addListener(browser.events.SELECT, function(data){
            for(var i in data){
                (function(item) {
                    var $template = $(fileTemplate.replace(/__name__/g, fieldCount));
                    $template.find('.file-item-title').text(item.name).attr('href', item.url);
                    $template.find('input[type="hidden"]').val(item.id);

                    fieldCount++;
                    $fieldContainer.append($template);
                })(data[i]);
            }
            box.modal('hide');
        });

        var box = $(browserTemplate);
        $('body').append(box);
        browser.attach(box);
        box.modal({
            show: false
        });
        $scope.find('.launch-file-browser-button').on('click', function(){
            box.modal('show');
        });

        $fieldContainer.on('click', '.file-item-remove', function(){
            $(this).closest('.file-item').remove();
        })
    });

});
