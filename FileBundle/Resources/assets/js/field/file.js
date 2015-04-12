define(['jquery', 'jqueryui', 'bootbox', 'cms/node/node/form', 'cms/file/browser/browser'], function ($, ui, bootbox, nodeForm, browserFactory) {

    nodeForm.registerWidget('file', function ($scope) {

        $scope.find('.file-collection-widget').each(function () {

            var $field = $(this),
                $launchButton = $field.find('.launch-file-browser-button'),
                $fieldContainer = $field.find('.file-items'),
                fileTemplate = $launchButton.data('prototype'),
                browserTemplate = $launchButton.data('browser'),
                fieldCount = $fieldContainer.children().length;

            var box = $(browserTemplate);
            var browser = browserFactory.create(box);

            browser.addListener(browserFactory.EVENTS.SELECT, function (data) {
                for (var i in data) {
                    (function (item) {
                        var $template = $(fileTemplate.replace(/__name__/g, fieldCount));
                        $template.find('.file-item-title').text(item.name).attr('href', item.url);
                        $template.find('input[type="hidden"]').val(item.id);

                        fieldCount++;
                        $fieldContainer.append($template);
                    })(data[i]);
                }
                box.modal('hide');
            });

            box.modal({
                show: false
            });
            $field.find('.launch-file-browser-button').on('click', function () {
                box.modal('show');
            });

            $fieldContainer.on('click', '.file-item-remove', function () {
                $(this).closest('.file-item').remove();
            })
        });
    });

});
