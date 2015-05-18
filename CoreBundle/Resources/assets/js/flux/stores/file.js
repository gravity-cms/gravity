'use strict';

(function() {
    define(['jquery', 'flux', 'event-emitter', 'cms/core/flux/dispatcher/app'], function ($, flux, EventEmitter, AppDispatcher) {

        var CHANGE_EVENT = 'change';

        var _files = {};

        // load the files
        $.ajax({
            url: ''
        }).success(function(data){
            _files = data;
        });

        /**
         * Create a TODO item.
         * @param  {string} text The content of the TODO
         */
        function create(name) {
            // Hand waving here -- not showing how this interacts with XHR or persistent
            // server-side storage.
            // Using the current timestamp + random number in place of a real id.
            var id = (+new Date() + Math.floor(Math.random() * 999999)).toString(36);
            _files[id] = {
                id: id,
                name: name
            };
        }

        /**
         * Update a TODO item.
         * @param  {string} id
         * @param {object} updates An object literal containing only the data to be
         *     updated.
         */
        function update(id, updates) {
            _files[id] = $.extend(true, {}, _files[id], updates);
        }

        /**
         * Update all of the TODO items with the same object.
         *     the data to be updated.  Used to mark all TODOs as completed.
         * @param  {object} updates An object literal containing only the data to be
         *     updated.
         */
        function updateAll(updates) {
            for (var id in _files) {
                update(id, updates);
            }
        }

        /**
         * Delete a TODO item.
         * @param  {string} id
         */
        function destroy(id) {
            delete _files[id];
        }

        var FileStore = $.extend(true, {}, EventEmitter.prototype, {

            /**
             * Get the entire collection of TODOs.
             * @return {object}
             */
            getAll: function() {
                return _files;
            },

            emitChange: function() {
                this.emit(CHANGE_EVENT);
            },

            /**
             * @param {function} callback
             */
            addChangeListener: function(callback) {
                this.on(CHANGE_EVENT, callback);
            },

            /**
             * @param {function} callback
             */
            removeChangeListener: function(callback) {
                this.removeListener(CHANGE_EVENT, callback);
            },

            CONSTANTS: {
                CREATE: null,
                DESTROY: null,
                UPDATE_NAME: null
            }
        });

        // Register callback to handle all updates
        AppDispatcher.register(function(action) {
            var name;

            switch(action.actionType) {
                case FileStore.CONSTANTS.CREATE:
                    name = action.name;
                    if (name !== '') {
                        create(name);
                        FileStore.emitChange();
                    }
                    break;

                case FileStore.CONSTANTS.UPDATE_NAME:
                    name = action.name.trim();
                    if (name !== '') {
                        update(action.id, { name: name });
                        FileStore.emitChange();
                    }
                    break;

                case FileStore.CONSTANTS.DESTROY:
                    destroy(action.id);
                    FileStore.emitChange();
                    break;

                default:
                // no op
            }
        });

        return FileStore;
    });
})();
