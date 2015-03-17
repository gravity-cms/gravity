'use strict';

define(['jquery', 'jqueryui', 'bootstrap', 'bootbox', 'cms/core/api'], function ($, ui, bs, bootbox, api) {

    var widgets = {};

    var nodeForm = {
        registerWidget: function (name, callback) {
            widgets[name] = callback;
            callback($(document));
        },
        bindWidget: function (name, $widget) {
            var callback = widgets[name];
            if(callback) {
                callback($widget);
            }
        }
    };

    $(document).ready(function () {

        var $form = $('form.api-save');

        $form.on('submit', function (e) {
            e.stopPropagation();
            e.preventDefault();

            api.saveForm($(this));
            return false;
        });

        $form.on('click', '.api-delete', function () {
            var a = this;
            bootbox.dialog({
                title: 'Delete node',
                message: 'Are you sure you want to remove this node?',
                buttons: {
                    cancel: {
                        label: 'Cancel'
                    },
                    delete: {
                        label: "Delete Node",
                        className: "btn-danger",
                        callback: function () {
                            api.call(a.href, {
                                method: 'DELETE',
                                success: function (o) {
                                    bootbox.alert('The node has been removed.', function () {

                                    });
                                }
                            });
                        }
                    }
                }
            });

            return false;
        });

        var $fieldGroups = $('.field-group');
        $fieldGroups.each(function () {
            var $fieldGroup = $(this);
            var $fieldGroupList = $fieldGroup.find('.field-group-list');
            var $addButton = $fieldGroup.find('.form-add-widget');
            var widgetLimit = parseInt($addButton.data('limit'));
            var widgetType = $addButton.data('widget-type');

            var getWidgetCount = function(){
                return $fieldGroupList.children('li').length;
            };
            var refreshWidgetState = function(){
                var c = getWidgetCount();
                if(widgetLimit == -1) {
                    $addButton.attr('disabled', false);
                } else {
                    if(c >= widgetLimit) {
                        $addButton.attr('disabled', true);
                    } else {
                        $addButton.attr('disabled', false);
                    }
                }


                return c;
            };
            $addButton.on('click', function () {
                if(widgetLimit !== -1 && refreshWidgetState() >= widgetLimit){
                    return false;
                }
                var data = $addButton.data('prototype').replace(/__name__/g, getWidgetCount());
                var $newElement = $(data);
                $fieldGroupList.append($newElement);
                $fieldGroupList.sortable('refresh');
                if(widgetType) {
                    nodeForm.bindWidget(widgetType, $newElement);
                }
                refreshWidgetState();
            });
            $fieldGroup.on('click', '.form-delete-widget', function(){
                var $btn = $(this);
                var $widget = $btn.closest('li.field-group-item ');

                if(refreshWidgetState() <= 0){
                    return false
                }
                $widget.remove();
                refreshWidgetState()
            });
            if (widgetLimit !== 1) {
                $fieldGroupList.sortable({
                    axis: "y",
                    containment: "parent",
                    handle: '.field-sort-icon'
                });
                //$fieldGroupList.disableSelection();
            }
            refreshWidgetState();
        });
    });

    return nodeForm
});
