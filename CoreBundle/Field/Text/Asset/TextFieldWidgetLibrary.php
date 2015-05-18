<?php

namespace Gravity\CoreBundle\Field\Text\Asset;

use Gravity\Component\Asset\AbstractAssetLibrary;

class TextFieldWidgetLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return array(
            '@GravityNodeBundle/field/text/text.js',
        );
    }

}
