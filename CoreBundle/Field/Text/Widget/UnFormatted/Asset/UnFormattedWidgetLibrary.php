<?php

namespace Gravity\CoreBundle\Field\Text\Widget\UnFormatted\Asset;

use Gravity\Component\Asset\AbstractAssetLibrary;

class UnFormattedWidgetLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return array(
            '@GravityNodeBundle/field/text/text.js',
        );
    }
}
