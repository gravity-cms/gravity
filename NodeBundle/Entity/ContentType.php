<?php

namespace Gravity\NodeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ContentType
 *
 * @package Gravity\NodeBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentType
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
     * @var ContentTypeField[]
     */
    protected $contentTypeFields;

    /**
     * @var Node[]
     */
    protected $nodes;

    /**
     * Initialisation
     */
    function __construct()
    {
        $this->contentTypeFields = new ArrayCollection();
        $this->nodes             = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @param ContentTypeField $contentTypeField
     */
    public function addContentTypeField(ContentTypeField $contentTypeField)
    {
        $this->contentTypeFields[] = $contentTypeField;
        $contentTypeField->setContentType($this);
    }

    /**
     * @param ContentTypeField $typeField
     */
    public function removeContentTypeField(ContentTypeField $typeField)
    {
        $this->contentTypeFields->removeElement($typeField);
    }

    /**
     * @return ContentTypeField[]
     */
    public function getContentTypeFields()
    {
        return $this->contentTypeFields;
    }


    /**
     * @param Node $node
     */
    public function addNode(Node $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * @param Node $node
     */
    public function removeNode(Node $node)
    {
        $this->nodes->removeElement($node);
    }

    /**
     * @return Node[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }
} 
