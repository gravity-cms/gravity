'use strict';

var ctrlr = '/app_dev.php';

define(['jquery', 'jqueryui', 'angular', 'bootstrap', 'cms/core/api'], function ($, ui, ang, bs, api) {

    var pluginsApp = angular.module('pluginsApp', []);

    pluginsApp.controller('PluginsCtrl', ['$scope', '$http', function ($scope, $http) {

        $scope.plugins = [];

        $scope.togglePlugin = function (plugin) {
            console.log(plugin);
            updatePluginState();
        };

        $http.get(ctrlr + '/api/core/plugin/list.json').success(function (data) {
            $scope.plugins = [];
            for(var i=0 ; i<data.length ; ++i){
                var pluginData = data[i];
                pluginData['hasChildrenEnabled'] = false;
                $scope.plugins.push(pluginData)
            }

            updatePluginState();
        });

        var updatePluginState = function(){
            for(var i=0 ; i<$scope.plugins.length ; ++i){

                var pluginData = $scope.plugins[i];
                if(pluginData.enabled) {
                    for (var j = 0; j < pluginData.dependencies.length; ++j) {

                        var dep = pluginData.dependencies[j];
                        for (var k = 0; k < $scope.plugins.length; ++k) {
                            if ($scope.plugins[k].name == dep && !$scope.plugins[k].enabled) {
                                $scope.plugins[k].enabled = true;
                                $scope.plugins[k].hasChildrenEnabled = true;
                            }
                        }

                    }
                }
            }
        };

        var enablePlugins = function(){
            var enabledPlugins = [];
            for(var i=0 ; i<$scope.plugins.length ; ++i){
                if($scope.plugins[i].enabled){
                    enabledPlugins.push($scope.plugins[i].name);
                }
            }

            $http.post(ctrlr + '/api/core/plugins/enable_check', enabledPlugins).success(function(data){
               if(data.valid){

               } else {

               }
            });
        };
    }]);

    angular.bootstrap(document, ['pluginsApp']);
});
