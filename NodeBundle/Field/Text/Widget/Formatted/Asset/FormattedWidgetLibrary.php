<?php

namespace Gravity\NodeBundle\Field\Text\Widget\Formatted\Asset;

use GravityCMS\Component\Asset\AbstractAssetLibrary;

class FormattedWidgetLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return array(
            '@GravityNodeBundle/field/text/text.js',
        );
    }
}
