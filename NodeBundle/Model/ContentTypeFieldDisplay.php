<?php

namespace Gravity\NodeBundle\Model;

use GravityCMS\Component\Field\Display\DisplaySettingsInterface;
use GravityCMS\CoreBundle\Entity\Field;

abstract class FieldDisplay
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
     * @var DisplaySettingsInterface
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
     * @return DisplaySettingsInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param DisplaySettingsInterface $config
     */
    public function setConfig(DisplaySettingsInterface $config)
    {
        $this->config = $config;
    }
} 
