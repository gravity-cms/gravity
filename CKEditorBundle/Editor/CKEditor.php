<?php

namespace Gravity\CKEditorBundle\Editor;

use GravityCMS\Component\Editor\EditorInterface;

/**
 * Class CKEditor
 *
 * @package Gravity\CKEditorBundle\Editor
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
            '@GravityCKEditorBundle/ckeditor/ckeditor.js',
        );
    }
} 
