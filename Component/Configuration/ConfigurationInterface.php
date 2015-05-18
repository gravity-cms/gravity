<?php

namespace Gravity\Component\Configuration;

/**
 * Interface ConfigurationInterface
 *
 * @package Gravity\Component\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface ConfigurationInterface
{
    /**
     * The configuration key name
     *
     * If this config in a sub-config of another config, this key will be it's index
     *
     * @return string
     */
    public function getConfigurationName();

    /**
     * Set the configuration name
     *
     * @param $name
     *
     * @return void
     */
    public function setConfigurationName($name);

    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType();

    /**
     * The name of the parent config
     *
     * @return string
     */
    public function getParent();

    /**
     * The form name or object
     *
     * @return string|object
     */
    public function getForm();
}
