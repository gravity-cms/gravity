<?php

namespace Gravity\Component\Entity\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gravity\Component\Field\Configuration\FieldSettingsConfiguration;
use Gravity\CoreBundle\Entity\FieldData;

/**
 * Class Field
 *
 * @package Gravity\Component\Entity\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class Field
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
    protected $delta;

    /**
     * @var FieldSettingsConfiguration
     */
    protected $config;

    /**
     * @var string
     */
    protected $fieldType;

    /**
     * @var FieldWidget
     */
    protected $widget;

    /**
     * @var FieldDisplay
     */
    protected $display;

    /**
     * @var FieldData[]
     */
    protected $data;

    function __construct()
    {
        $this->data = new ArrayCollection();
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
     * @return FieldSettingsConfiguration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param FieldSettingsConfiguration $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * @param string $fieldType
     */
    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * @return FieldWidget
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @param FieldWidget $widget
     */
    public function setWidget(FieldWidget $widget)
    {
        $this->widget = $widget;
    }

    /**
     * @return FieldDisplay
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * @param FieldDisplay $display
     */
    public function setDisplay(FieldDisplay $display)
    {
        $this->display = $display;
    }

    /**
     * @return FieldData[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param FieldData[] $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function addData(FieldData $data)
    {
        $this->data[] = $data;
    }

    public function removeData(FieldData $data)
    {
        $this->data->removeElement($data);
    }


}
