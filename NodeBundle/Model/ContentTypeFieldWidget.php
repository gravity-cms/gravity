<?php

namespace Gravity\NodeBundle\Model;

use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;
use GravityCMS\CoreBundle\Entity\Field;

abstract class FieldWidget
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
     * @var int
     */
    protected $order;

    /**
     * @var Field
     */
    protected $typeField;

    /**
     * @var WidgetSettingsInterface
     */
    protected $config;

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
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return Field
     */
    public function getTypeField()
    {
        return $this->typeField;
    }

    /**
     * @param Field $field
     */
    public function setTypeField(Field $field)
    {
        $this->typeField = $field;
    }

    /**
     * @return WidgetSettingsInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param WidgetSettingsInterface $config
     */
    public function setConfig(WidgetSettingsInterface $config)
    {
        $this->config = $config;
    }

    /**
     *
     */
    public function unsetConfig()
    {
        $this->config = null;
    }
} 
