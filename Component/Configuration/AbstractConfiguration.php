<?php

namespace Gravity\Component\Configuration;

abstract class AbstractConfiguration implements ConfigurationInterface
{
    private $configurationName;

    /**
     * {@inheritdoc}
     */
    public function getConfigurationName()
    {
        return $this->configurationName;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfigurationName($name)
    {
        $this->configurationName = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'root';
    }
}
