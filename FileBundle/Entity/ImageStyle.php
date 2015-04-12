<?php


namespace Gravity\FileBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ImageStyle
 *
 * @package Gravity\FileBundle\Entity
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyle 
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
    protected $label;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var ImageStyleOperation
     */
    protected $operations;

    function __construct()
    {
        $this->operations = new ArrayCollection();
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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
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
     * @return ImageStyleOperation[]
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * @param ImageStyleOperation $operations
     */
    public function addOperations(ImageStyleOperation $operations)
    {
        $this->operations[] = $operations;
    }

    /**
     * @param ImageStyleOperation $operations
     */
    public function removeOperations(ImageStyleOperation $operations)
    {
        $this->operations->removeElement($operations);
    }
}
