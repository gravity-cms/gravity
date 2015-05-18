<?php

namespace Gravity\Component\Theme\Layout\Configuration;

use Gravity\Component\Configuration\AbstractConfiguration;
use Gravity\Component\Theme\Block\Configuration\AbstractBlockConfiguration;
use Gravity\Component\Theme\Layout\Position\PositionInterface;

class LayoutConfiguration extends AbstractConfiguration
{
    protected $name;

    /**
     * @var array
     */
    protected $blocks;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function addBlock(PositionInterface $position, AbstractBlockConfiguration $block)
    {
        if(!in_array($block->getConfigurationName(), $this->blocks))
        {
            $this->blocks[$position->getName()][] = $block->getConfigurationName();
        }
    }

    /**
     * @return array
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param array $blocks
     */
    public function setBlocks($blocks)
    {
        $this->blocks = $blocks;
    }

    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType()
    {
        return 'layout';
    }

    /**
     * The form name or object
     *
     * @return string|object
     */
    public function getForm()
    {
        return new LayoutConfigurationForm();
    }
}
