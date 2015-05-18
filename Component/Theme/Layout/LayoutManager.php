<?php

namespace Gravity\Component\Theme\Layout;

use Gravity\Component\Configuration\ConfigurationInterface;
use Gravity\Component\Configuration\ConfigurationManager;
use Gravity\Component\Theme\Block\BlockInterface;
use Gravity\Component\Theme\Block\BlockManager;
use Gravity\Component\Theme\Layout\Configuration\LayoutConfiguration;
use Gravity\Component\Theme\Layout\Position\PositionInterface;

class LayoutManager
{
    /**
     * @var PositionInterface
     */
    protected $positions = array();

    /**
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * @var BlockManager
     */
    protected $blockManager;

    protected $layoutConfiguration;

    function __construct(ConfigurationManager $configurationManager, BlockManager $blockManager)
    {
        $this->configurationManager = $configurationManager;
        $this->blockManager         = $blockManager;
    }

    public function getLayouts()
    {
        return $this->configurationManager->getSet('layout:%');
    }

    /**
     * @return BlockInterface[]
     */
    public function getBlocks()
    {
        return $this->blockManager->getBlocks();
    }

    /**
     * @return PositionInterface[]
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @param array $positions
     */
    public function setPositions(array $positions)
    {
        foreach ($positions as $position) {
            $this->addPosition($position);
        }
    }

    /**
     * @param PositionInterface $position
     */
    public function addPosition(PositionInterface $position)
    {
        $this->positions[$position->getName()] = $position;
    }

    /**
     * @param PositionInterface $position
     */
    public function removePosition(PositionInterface $position)
    {
        unset($this->positions[$position->getName()]);
    }

    /**
     * @param $id
     *
     * @return LayoutConfiguration
     */
    public function get($id)
    {
        return $this->configurationManager->get('layout:'.$id);
    }

    /**
     * @return LayoutConfiguration
     */
    public function createLayout()
    {
        return new LayoutConfiguration();
    }
}
