<?php


namespace Gravity\CoreBundle\Asset\Field;

use Gravity\Component\Asset\AbstractAssetLibrary;

/**
 * Class ConfigNameAssetLibrary
 *
 * @package Gravity\CoreBundle\Asset\Field
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigNameAssetLibrary extends AbstractAssetLibrary
{
    public function getStylesheets()
    {
        return [
            '@GravityCoreBundle/fields/config-name.scss',
        ];
    }
}
