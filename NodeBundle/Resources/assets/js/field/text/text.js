define(['jquery', 'jqueryui', 'bootstrap', 'select2', 'cms/node/editor/editor', 'cms/node/node/form'], function ($, ui, bs, s2, editor, nodeForm) {
    nodeForm.registerWidget('text', function($scope){
        editor.bindEditor('ckeditor', $scope);
    });
});
