'use strict';

define(['jquery', 'cms/file/form/dropzone', 'cms/core/api'], function ($, dropzone, api) {

    var EVENTS = {
        SELECT: 'select',
        DELETE: 'delete'
    };

    return {

        create: function($element, options){

            var settings = $.extend(true, {
                uploadUrl: null,
                filesUrl: null,
                mimeTypes: '*/*'
            }, options);

            var filePage = 1;
            var files = [];
            var fileIndex = {};
            var $library = $element.find('.browser-library-items');
            var libraryItemPrototype = $library.data('prototype');
            var selectedItems = 0;
            var eventListeners = [];

            var addListener = function (eventName, callback) {
                eventListeners[eventName] = eventListeners[eventName] || [];
                eventListeners[eventName].push(callback);
            };

            var callListener = function (eventName, event) {
                var events = eventListeners[eventName] || [];
                for(var i in events){
                    events[i](event);
                }
            };
            
            var buildItem = function(item){
                fileIndex[item.id] = item; // ensure the id is in the index
                return libraryItemPrototype
                    .replace(/__file_id__/g, item.id)
                    .replace(/__file_name__/g, item.name)
                    .replace(/__file_thumbnail__/g, item.styles.thumbnail);
            };

            dropzone.addListener(dropzone.events.UPLOAD, function (file, response) {
                $library.prepend(buildItem(data.data[i]));
                files.unshift(response.data);
            });

            var promise = $
                .ajax({
                    url: settings.filesUrl,
                    data: {
                        page: filePage
                    }
                })
                .success(function(data){
                    var html = '';
                    files = files.concat(data.data);
                    for(var i in data.data){
                        html += buildItem(data.data[i]);
                    }
                    $library.html(html);
                });

            $library.on('change', 'input.browser-library-item-input', function(){
                var $input = $(this);
                selectedItems = $library.find('input.browser-library-item-input:checked');
            });

            $element.find('.browser-select-files-button').on('click', function(e){
                if(selectedItems) {
                    var eventItems = [];
                    selectedItems.each(function () {
                        eventItems.push(fileIndex[this.value]);
                    });
                    callListener(EVENTS.SELECT, eventItems);
                }
                e.preventDefault();
                return false;
            });

            dropzone.dropzone($element.find('.dropzone'), {
                url: settings.uploadUrl,
                template: '<div class="dz-preview dz-file-preview">' +
                '    <div class="dz-details">' +
                '        <div class="dz-filename">' +
                '            <span data-dz-name></span>' +
                '        </div>' +
                '        <div class="dz-size">File size: <span data-dz-size></span></div>' +
                '        <div class="dz-thumbnail-wrapper">' +
                '            <div class="dz-thumbnail">' +
                '                <img data-dz-thumbnail>' +
                '                <span class="dz-nopreview">No preview</span>' +
                '                <div class="dz-error-mark"><i class="fa fa-times-circle-o"></i></div>' +
                '                <div class="dz-error-message"><span data-dz-errormessage></span></div>' +
                '            </div>' +
                '        </div>' +
                '    </div>' +
                '    <div class="progress progress-striped active">' +
                '        <div class="progress-bar progress-bar-success" data-dz-uploadprogress></div>' +
                '    </div>' +
                '</div>'
            });

            return {
                addListener: addListener
            }
        },

        EVENTS: EVENTS
    }
});
