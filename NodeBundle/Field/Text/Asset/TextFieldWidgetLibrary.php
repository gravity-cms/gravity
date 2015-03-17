<?php

namespace Gravity\NodeBundle\Field\Text\Asset;

use GravityCMS\Component\Asset\AbstractAssetLibrary;

class TextFieldWidgetLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return array(
            '@GravityNodeBundle/field/text/text.js',
        );
    }

}
