/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here.
    // For the complete reference:
    // http://docs.ckeditor.com/#!/api/CKEDITOR.config

    // config.skin = 'BootstrapCK-Skin';

    // The toolbar groups arrangement, optimized for two toolbar rows.
    config.toolbarGroups = [
        { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
        { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
        { name: 'links' },
        { name: 'insert',       groups: [ 'featurette', 'jumbotron' ] },
        { name: 'forms' },
        { name: 'tools' },
        { name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'pbckcode' } ,
        '/',
        { name: 'bootstrap' },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
        { name: 'colors' },
        { name: 'styles' },
        { name: 'others' }
    ];

    // Remove some buttons, provided by the standard plugins, which we don't
    // need to have in the Standard(s) toolbar.
    config.removeButtons = 'About,Maximize';

    config.removePlugins = 'elementspath';

    //config.extraPlugins = 'youtube,autogrow,pbckcode,linestorm-media,carousel,featurette,jumbotron,trifold,listgroup,badge';
    config.extraPlugins = 'divarea';

    config.contentsCss = '/css/cms/core/main.css';

    // ADVANCED CONTENT FILTER (ACF)
    // ACF protects your CKEditor instance of adding unofficial tags
    // however it strips out the pre tag of pbckcode plugin
    // add this rule to enable it, useful when you want to re edit a post
    config.allowedContent = true;//'pre[*]{*}(*)'; // add other rules here

    config.scayt_autoStartup = true;

    config.stylesSet = false;
    //config.stylesSet = 'mystyles:'+window.lineStormTags.assets.path+'/bundles/linestormpost/css/post.css';

    // PBCKCODE CUSTOMIZATION
    config.pbckcode = {
        // An optional class to your pre tag.
        cls : '',

        // The syntax highlighter you will use in the output view
        highlighter : 'HIGHLIGHT',

        // An array of the available modes for you plugin.
        // The key corresponds to the string shown in the select tag.
        // The value correspond to the loaded file for ACE Editor.
        modes :  [ ['PHP', 'php'], ['JS', 'javascript'], ['CSS', 'css'], ['HTML', 'html'],
            ['YAML', 'yaml'], ['SQL', 'sql'], ['Python', 'python'], ['JSON', 'json'] ],

        // The theme of the ACE Editor of the plugin.
        theme : 'twilight',

        // Tab indentation (in spaces)
        tab_size : '4'
    };

    // Se the most common block elements.
    config.format_tags = 'p;h1;h2;h3;h4;h5;h6;pre';

    // Make dialogs simpler.
    config.removeDialogTabs = 'image:advanced;link:advanced';
};
