<?php

namespace Gravity\TagBundle\Asset;

use GravityCMS\Component\Asset\AbstractAssetLibrary;

class TagAutoCompleteLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return [
            '@GravityTagBundle/node/tags.js',
        ];
    }

}
