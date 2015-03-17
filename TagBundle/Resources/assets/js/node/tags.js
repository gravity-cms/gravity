define(['jquery', 'jqueryui', 'bootstrap', 'select2', 'cms/node/node/form'], function ($, ui, bs, s2, nodeForm) {

    nodeForm.registerWidget('tag', function($scope){
        $scope.find('input.content-tags').each(function(){
            var $input = $(this),
                isMultiple = this.dataset.multiple === "1" || this.dataset.multiple === 1,
                allowNew = this.dataset.allowNew === "1" || this.dataset.allowNew === 1;
            $input.wrap('<div class="select2-primary"></div>').select2({
                placeholder: "Select tags",
                multiple: isMultiple,
                tags: allowNew,
                initSelection: function (element, callback) {
                    var items = element.val().split(',');
                    var data = [];
                    for( var i=0 ; i<items.length ; ++i ){
                        data.push({ id: items[i], text: items[i] });
                    }
                    if(isMultiple){
                        callback(data);
                    } else {
                        if("undefined" != typeof data[0]) {
                            callback(data[0]);
                        }
                    }
                },
                ajax: {
                    url: $input.data('url'),
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params // search term
                        };
                    },
                    cache: true,
                    results: function (data) {
                        // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data
                        return {
                            results: data.items
                        };
                    }
                },
                minimumInputLength: 2
            });
        });
    });

});
