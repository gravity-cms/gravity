<?php

namespace Gravity\TagBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Tag
 *
 * @package Gravity\TagBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Tag
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
     * @var Tag
     */
    protected $parentTag;

    /**
     * @var Tag[]
     */
    protected $childTags;

    function __construct()
    {
        $this->childTags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Tag
     */
    public function getParentTag()
    {
        return $this->parentTag;
    }

    /**
     * @param Tag $parentTag
     */
    public function setParentTag(Tag $parentTag)
    {
        $this->parentTag = $parentTag;
    }

    /**
     * @return Tag[]
     */
    public function getChildTags()
    {
        return $this->childTags;
    }

    /**
     * @param Tag $childTag
     */
    public function addChildTags(Tag $childTag)
    {
        $this->childTags[] = $childTag;
    }

    /**
     * @param Tag $childTag
     */
    public function removeChildTags(Tag $childTag)
    {
        $this->childTags->removeElement($childTag);
    }
} 
