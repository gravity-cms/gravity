'use strict';

define(['jquery', 'react', 'cms/core/flux/stores/file', 'cms/core/flux/actions/file'], function ($, React, FileStore, FileActions) {

    /**
     * Retrieve the current TODO data from the FileStore
     */
    function getFileState() {
        return {
            all: FileStore.getAll()
        };
    }

    return React.createClass({

        getInitialState: function() {
            return getFileState();
        },

        componentDidMount: function() {
            setInterval(function(){
                FileActions.create('hello!');
            }, 1000);
            FileStore.addChangeListener(this._onChange);
        },

        componentWillUnmount: function() {
            FileStore.removeChangeListener(this._onChange);
        },

        /**
         * @return {object}
         */
        render: function() {

            var item;
            var files = this.state.all;
            var fileTags = [];

            for (var key in files) {
                item = files[key];
                fileTags.push(<span>{item.name}</span>);
            }

            return (
                <div class="file-browser">
                    hello!
                    {fileTags}
                </div>
            );
        },

        /**
         * Event handler for 'change' events coming from the FileStore
         */
        _onChange: function() {
            this.setState(getFileState());
        }

    });

});
