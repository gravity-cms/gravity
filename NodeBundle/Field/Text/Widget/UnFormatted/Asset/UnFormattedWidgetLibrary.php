<?php

namespace Gravity\NodeBundle\Field\Text\Widget\UnFormatted\Asset;

use GravityCMS\Component\Asset\AbstractAssetLibrary;

class UnFormattedWidgetLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return array(
            '@GravityNodeBundle/field/text/text.js',
        );
    }
}
