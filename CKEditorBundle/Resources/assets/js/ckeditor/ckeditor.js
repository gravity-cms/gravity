CKEDITOR_BASEPATH = '/vendor/ckeditor/';
define(['jquery', 'jckeditor', 'cms/node/editor/editor'], function ( $, ckeditor, editor) {

    CKEDITOR.config.customConfig = '/js/cms/editor_cke/ckeditor/config.js';

    /*
    CKEDITOR.plugins.addExternal( 'pbckcode',           window.lineStormTags.assets.path+'/vendor/PBCKCode/' );
    CKEDITOR.plugins.addExternal( 'youtube',            window.lineStormTags.assets.path+'/vendor/ckeditor-youtube-plugin/youtube/' );
    CKEDITOR.plugins.addExternal( 'linestorm-media',    window.lineStormTags.assets.path+'/bundles/linestormarticlecomponent/js/ckeditor/plugins/linestorm-media/' );

    CKEDITOR.plugins.addExternal( 'carousel',           window.lineStormTags.assets.path+'/bundles/linestormarticlecomponent/js/ckeditor/plugins/carousel/' );
    CKEDITOR.plugins.addExternal( 'featurette',         window.lineStormTags.assets.path+'/bundles/linestormarticlecomponent/js/ckeditor/plugins/featurette/' );
    CKEDITOR.plugins.addExternal( 'jumbotron',          window.lineStormTags.assets.path+'/bundles/linestormarticlecomponent/js/ckeditor/plugins/jumbotron/' );
    CKEDITOR.plugins.addExternal( 'trifold',            window.lineStormTags.assets.path+'/bundles/linestormarticlecomponent/js/ckeditor/plugins/trifold/' );
    CKEDITOR.plugins.addExternal( 'listgroup',          window.lineStormTags.assets.path+'/bundles/linestormarticlecomponent/js/ckeditor/plugins/listgroup/' );
    CKEDITOR.plugins.addExternal( 'badge',              window.lineStormTags.assets.path+'/bundles/linestormarticlecomponent/js/ckeditor/plugins/badge/' );
    */

    editor.registerEditor('ckeditor', function($scope){
        $scope.find('textarea.wysiwyg-editor').each(function(){
            var $editor = $(this);
            $editor.ckeditor().focus();
        });
    });

});
