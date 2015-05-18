<?php

namespace Gravity\Component\Theme\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class LayoutPositionBlock
 *
 * @package Gravity\Component\Theme\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class LayoutPositionBlock
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Layout
     */
    protected $layout;

    /**
     * @var LayoutPosition
     */
    protected $position;

    /**
     * @var Block
     */
    protected $block;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return LayoutPosition
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param LayoutPosition $position
     */
    public function setPosition(LayoutPosition $position)
    {
        $this->position = $position;
    }

    /**
     * @return Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param Layout $layout
     */
    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return Block
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param Block $block
     */
    public function setBlock(Block $block)
    {
        $this->block = $block;
    }
}
