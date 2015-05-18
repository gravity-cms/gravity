<?php

namespace Gravity\Component\Theme\Block;

use Gravity\Component\Configuration\ConfigurationManager;
use Gravity\Component\Theme\View\ViewInterface;


/**
 * Class BlockManager
 *
 * @package Gravity\Component\Block
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class BlockManager
{
    /**
     * @var BlockInterface[]
     */
    protected $blocks = array();

    /**
     * @var ConfigurationManager
     */
    protected $configurationManager;

    function __construct(ConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    public function create($name, BlockInterface $block)
    {
        $config = $block->getDefaultConfiguration();
        $this->configurationManager->create($name, $config);

        return $config;
    }

    /**
     * @return BlockInterface[]
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param string $name
     *
     * @return BlockInterface
     */
    public function getBlock($name)
    {
        return $this->blocks[$name];
    }

    /**
     * @param BlockInterface[] $blocks
     */
    public function setBlocks(array $blocks)
    {
        foreach ($blocks as $block) {
            $this->addBlock($block);
        }
    }

    /**
     * @param BlockInterface $block
     */
    public function addBlock(BlockInterface $block)
    {
        $this->blocks[$block->getType()] = $block;
    }


    /**
     * @param ViewInterface $view
     *
     * @return BlockInterface[]
     */
    public function getBlocksForView(ViewInterface $view)
    {
        $blocks = array();
        foreach ($this->blocks as $block) {
            if ($block->supports($view)) {
                $blocks[] = $block;
            }
        }

        return $blocks;
    }
}
