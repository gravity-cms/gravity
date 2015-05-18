'use strict';

(function() {
    define(['jquery', 'cms/core/flux/dispatcher/app', 'cms/core/flux/stores/file'], function ($, AppDispatcher, FileStore) {

        return {

            /**
             * @param  {string} text
             */
            create: function(name) {
                AppDispatcher.dispatch({
                    actionType: FileStore.CONSTANTS.CREATE,
                    name: name
                });
            },

            /**
             * @param  {string} id The ID of the ToDo item
             * @param  {string} text
             */
            updateName: function(id, name) {
                AppDispatcher.dispatch({
                    actionType: FileStore.CONSTANTS.UPDATE_NAME,
                    id: id,
                    name: name
                });
            },

            /**
             * @param  {string} id
             */
            destroy: function(id) {
                AppDispatcher.dispatch({
                    actionType: FileStore.CONSTANTS.DESTROY,
                    id: id
                });
            }
        };
    });
})();
