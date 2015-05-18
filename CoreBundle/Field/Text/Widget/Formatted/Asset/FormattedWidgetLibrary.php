<?php

namespace Gravity\CoreBundle\Field\Text\Widget\Formatted\Asset;

use Gravity\Component\Asset\AbstractAssetLibrary;

class FormattedWidgetLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return array(
            '@GravityNodeBundle/field/text/text.js',
        );
    }
}
