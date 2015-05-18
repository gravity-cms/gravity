<?php

namespace Gravity\Component\Theme\Block\Configuration;

use Gravity\Component\Configuration\AbstractConfiguration;

abstract class AbstractBlockConfiguration extends AbstractConfiguration
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    final public function getParent()
    {
        return 'root';
    }

    /**
     * Get the type of the config
     *
     * @return string
     */
    final public function getType()
    {
        return 'block';
    }

}
