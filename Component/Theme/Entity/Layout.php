<?php

namespace Gravity\Component\Theme\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Layout
 *
 * @package Gravity\Component\Theme\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class Layout
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var LayoutPositionBlock[]
     */
    protected $positions;

    function __construct()
    {
        $this->positions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return LayoutPosition[]
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @return Block[]
     */
    public function getBlocks()
    {
        $blockData = array();
        foreach($this->positions as $position)
        {
            $blockData[$position->getPosition()->getId()][] = $position->getBlock();
        }

        return $blockData;
    }

    /**
     * @param LayoutPosition $position
     *
     * @return Block[]
     */
    public function getPositionBlocks(LayoutPosition $position)
    {
        $blockData = array();
        foreach($this->positions as $blockPosition)
        {
            if($position->getId() === $blockPosition->getPosition()->getId()) {
                $blockData[] = $blockPosition->getBlock();
            }
        }

        return $blockData;
    }

    /**
     * @param LayoutPosition $position
     */
    public function addPosition(LayoutPosition $position)
    {
        $this->positions[] = $position;
    }

    /**
     * @param LayoutPosition $position
     */
    public function removePosition(LayoutPosition $position)
    {
        $this->positions->removeElement($position);
    }
}
