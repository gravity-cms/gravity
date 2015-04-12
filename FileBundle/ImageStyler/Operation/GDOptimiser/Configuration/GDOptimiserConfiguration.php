<?php


namespace Gravity\FileBundle\ImageStyler\Operation\GDOptimiser\Configuration;

use GravityCMS\Component\Configuration\AbstractConfiguration;

/**
 * Class GDOptimiserConfiguration
 *
 * @package Gravity\FileBundle\ImageStyler\Operation\GDOptimiser\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class GDOptimiserConfiguration extends AbstractConfiguration
{
    protected $quality = 75;

    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType()
    {
        return 'operation';
    }

    /**
     * The form name or object
     *
     * @return string|object
     */
    public function getForm()
    {
        return new GDOptimiserConfigurationForm();
    }

    /**
     * @return mixed
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param mixed $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }
}
