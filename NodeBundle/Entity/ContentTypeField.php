<?php

namespace Gravity\NodeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use GravityCMS\Component\Field\Configuration\FieldSettingsConfiguration;
use GravityCMS\CoreBundle\Entity\Field;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ContentTypeField
 *
 * @package Gravity\NodeBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentTypeField
{
    /**
     * @var integer
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
     * @var int
     */
    protected $order;

    /**
     * @var FieldSettingsConfiguration
     */
    protected $config;

    /**
     * @var ContentType
     */
    protected $contentType;

    /**
     * @var NodeContent
     */
    protected $contents;

    /**
     * @var Field
     */
    protected $field;

    /**
     * @var ContentTypeFieldWidget
     */
    protected $viewWidget;

    /**
     * @var ContentTypeFieldDisplay
     */
    protected $viewDisplay;

    function __construct()
    {
        $this->contents = new ArrayCollection();
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
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Field $field
     */
    public function setField(Field $field)
    {
        $this->field = $field;
    }

    /**
     * @return Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param ContentType $contentType
     */
    public function setContentType(ContentType $contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return ContentType
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @return FieldSettingsConfiguration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param FieldSettingsConfiguration $config
     */
    public function setConfig(FieldSettingsConfiguration $config)
    {
        $this->config = $config;
    }

    /**
     * @return NodeContent[]
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param NodeContent $content
     */
    public function addContents($content)
    {
        $this->contents[] = $content;
    }

    /**
     * @param NodeContent $content
     */
    public function removeContents($content)
    {
        $this->contents->removeElement($content);
    }

    /**
     * @return ContentTypeFieldWidget
     */
    public function getViewWidget()
    {
        return $this->viewWidget;
    }

    /**
     * @param ContentTypeFieldWidget $viewWidget
     */
    public function setViewWidget(ContentTypeFieldWidget $viewWidget)
    {
        $this->viewWidget = $viewWidget;
    }

    /**
     * @return ContentTypeFieldDisplay
     */
    public function getViewDisplay()
    {
        return $this->viewDisplay;
    }

    /**
     * @param ContentTypeFieldDisplay $viewDisplay
     */
    public function setViewDisplay(ContentTypeFieldDisplay $viewDisplay)
    {
        $this->viewDisplay = $viewDisplay;
    }
} 
