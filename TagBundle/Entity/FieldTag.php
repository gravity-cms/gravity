<?php

namespace Gravity\TagBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gravity\TagBundle\Entity\Tag;
use Gravity\NodeBundle\Entity\NodeContent;
use GravityCMS\CoreBundle\Entity\FieldData;

/**
 * Class FieldTag
 *
 * @package Gravity\TagBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTag extends FieldData
{
    /**
     * @var Tag[]
     */
    protected $tags;

    function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * @return Tag
     */
    public function getTags()
    {
        return $this->tags;
    }
} 
