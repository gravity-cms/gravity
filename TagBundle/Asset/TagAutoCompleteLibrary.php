<?php

namespace Gravity\TagBundle\Asset;

use Gravity\Component\Asset\AbstractAssetLibrary;

class TagAutoCompleteLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return [
            '@GravityTagBundle/node/tags.js',
        ];
    }

}
