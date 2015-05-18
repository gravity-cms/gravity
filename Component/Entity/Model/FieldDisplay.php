<?php

namespace Gravity\Component\Entity\Model;

use Doctrine\ORM\Mapping as ORM;
use Gravity\Component\Field\Display\DisplaySettingsInterface;

/**
 * Class FieldDisplay
 *
 * @package Gravity\Component\Entity\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
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
    protected $delta;

    /**
     * @var Field
     */
    protected $field;

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
    public function getDelta()
    {
        return $this->delta;
    }

    /**
     * @param int $delta
     */
    public function setDelta($delta)
    {
        $this->delta = $delta;
    }

    /**
     * @return Field
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param Field $field
     */
    public function setField(Field $field)
    {
        $this->field = $field;
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

    /**
     *
     */
    public function unsetConfig()
    {
        $this->config = null;
    }
} 
