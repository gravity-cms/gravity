<?php

namespace Gravity\FileBundle\Configuration;

use Gravity\FileBundle\File\StreamWrapper\StreamWrapperInterface;
use GravityCMS\Component\Configuration\AbstractConfiguration;

/**
 * Class FileConfiguration
 *
 * @package Gravity\FileBundle\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileConfiguration extends AbstractConfiguration
{
    /**
     * @var string
     */
    protected $defaultStreamWrapperScheme;

    /**
     * @var string[]
     */
    protected $allowedExtensions = [];


    public function getConfigurationName()
    {
        return 'settings';
    }

    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType()
    {
        return 'file';
    }

    /**
     * The form name or object
     *
     * @return string|object
     */
    public function getForm()
    {
        return 'file_configuration';
    }

    /**
     * @return string
     */
    public function getDefaultStreamWrapperScheme()
    {
        return $this->defaultStreamWrapperScheme;
    }

    /**
     * @param string $defaultStreamWrapperScheme
     */
    public function setDefaultStreamWrapperScheme($defaultStreamWrapperScheme)
    {
        $this->defaultStreamWrapperScheme = $defaultStreamWrapperScheme;
    }

    /**
     * @return string[]
     */
    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }

    /**
     * @param string[] $allowedExtensions
     */
    public function setAllowedExtensions(array $allowedExtensions)
    {
        $this->allowedExtensions = array_map(function($v){
            return strtolower($v);
        }, $allowedExtensions);
    }
}
