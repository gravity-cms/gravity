<?php

namespace Gravity\Component\Theme\Assetic;

/**
 * Class GravityAssetManager
 *
 * @package Gravity\Component\Theme\Assetic
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class GravityAssetManager
{
    protected $assetMap = array();

    public function addAssetMap(array $assetMap = array())
    {
        $this->assetMap += $assetMap;
    }

    public function hasAsset($name)
    {
        return array_key_exists($name, $this->assetMap);
    }

    public function getAsset($name)
    {
        if($this->hasAsset($name))
        {
            return $this->assetMap[$name];
        }
        else
        {
            return null;
        }
    }
} 
