<?php

namespace Nefarian\CmsBundle\Plugin\EditorCKE\Editor;

use Nefarian\CmsBundle\Editor\EditorInterface;

/**
 * Class CKEditor
 *
 * @package Nefarian\CmsBundle\Plugin\EditorCKE\Editor
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class CKEditor implements EditorInterface
{
    public function getName()
    {
        return 'ckeditor';
    }

    public function getAssets()
    {
        return array(
            '@plugin_editor_cke/ckeditor/ckeditor.js',
        );
    }
} 
