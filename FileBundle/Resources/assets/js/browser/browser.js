'use strict';

define(['jquery', 'angular', 'cms/file/form/dropzone', 'cms/core/api'], function ($, ang, dropzone, api) {

    var EVENTS = {
        SELECT: 'select',
        DELETE: 'delete'
    };

    var create = function (targetAppElement) {
        var eventListeners = [];
        for (var i in EVENTS) {
            eventListeners[EVENTS[i]] = [];
        }

        var callListener = function (eventName, event) {
            for (var i in eventListeners[eventName]) {
                eventListeners[eventName][i](event);
            }
        };

        angular.module('FileBrowser', [])
            .controller('FileBrowserController', ['$scope', function ($scope) {
            }])
            .directive('ngFileBrowser', ['$http', function ($http) {
                return {
                    restrict: 'A',
                    template: '<div class="file-browser">' +
                    '   <div class="file-browser-header">' +
                    '       <ul class="nav nav-tabs">' +
                    '           <li ng-class="{\'active\': page.tab == \'upload\' }">' +
                    '               <a href="#browser-upload" ng-click="page.tab = \'upload\'">Upload</a>' +
                    '           </li>' +
                    '           <li ng-class="{\'active\': page.tab == \'library\' }">' +
                    '               <a href="#browser-library" ng-click="page.tab = \'library\'">Library</a>' +
                    '           </li>' +
                    '       </ul>' +
                    '   </div>' +
                    '   <div class="tab-content">' +
                    '       <div class="tab-pane fade" ng-class="{\'in active\': page.tab == \'upload\' }">' +
                    '           <div class="dropzone dropzone-box">' +
                    '               <!-- dropzone -->' +
                    '           </div>' +
                    '       </div>' +
                    '       <div class="tab-pane fade" ng-class="{\'in active\': page.tab == \'library\' }">' +
                    '           <div class="browser-library-header clearfix" ng-show="selectedCount>0">' +
                    '               <div class="pull-right"> <span class="text-muted">({{ selectedCount }} Selected)</span> ' +
                    '                   <button type="button" class="btn btn-primary" ng-click="getSelected()"><i class="fa fa-check"></i> Select</button>' +
                    '                   <button type="button" class="btn btn-danger" ng-click="deleteSelected()"><i class="fa fa-trash-o"></i> Delete</button>' +
                    '               </div>' +
                    '           </div>' +
                    '           <div class="browser-library-items">' +
                    '               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 browser-library-item" ng-repeat="file in files">' +
                    '                   <input type="checkbox" value="{{ file.id }}" ng-model="selected[file.id]" id="file-check-{{ file.id }}" name="files[]" ng-src="{{ file.url }}" ng-change="selectFile(file)" >' +
                    '                   <label class="thumbnail" for="file-check-{{ file.id }}">' +
                    '                       <img ng-src="{{ file.styles.thumbnail }}" >' +
                    '                       <div class="caption">' +
                    '                           <h4>{{ file.name }}</h4>' +
                    '                       </div>' +
                    '                       <i class="file-selected fa fa-check"></i>' +
                    '                   </label>' +
                    '               </div><div class="clearfix"></div>' +
                    '           </div>' +
                    '       </div>' +
                    '   </div>' +
                    '</div>',
                    controller: function ($scope) {
                        $scope.selected = {};
                        $scope.selectedCount = 0;
                        $scope.files = [];
                        $scope.page = {
                            tab: 'upload'
                        };

                        $scope.$watch('selected', function () {
                            $scope.selectedCount = Object.keys($scope.selected).length;
                        });

                        $scope.selectFile = function (file) {
                            $scope.selectedCount = Object.keys($scope.selected).length;
                        };

                        $scope.getSelected = function () {
                            var selectedIds = Object.keys($scope.selected);
                            var selectedFiles = $scope.files.map(function (i) {
                                if ($.inArray(i.id.toString(), selectedIds) !== -1) {
                                    return i;
                                }
                            }).filter(function (n) {
                                return n != undefined
                            });
                            callListener(EVENTS.SELECT, selectedFiles);
                            $scope.selected = {};
                        };

                        $scope.deleteSelected = function () {
                            callListener(EVENTS.DELETE, $scope.selected);
                        };

                        dropzone.addListener(dropzone.events.UPLOAD, function (file, response) {
                            $scope.files.unshift(response.data);
                        });
                    },
                    link: function (scope, element, attrs) {

                        $http
                            .get(attrs.filesUrl)
                            .success(function (data) {
                                scope.files = scope.files.concat(data.data);
                            });

                        dropzone.dropzone(element.find('.dropzone'), {
                            url: attrs.uploadUrl,
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
                    }
                };
            }]);

        angular.bootstrap(targetAppElement, ['FileBrowser']);

        return {
            addListener: function (event, callback) {
                eventListeners[event].push(callback);
            }
        }
    };

    return {

        create: function(targetAppElement){
            return create(targetAppElement);
        },

        EVENTS: EVENTS

    }
});
