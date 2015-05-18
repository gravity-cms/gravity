<?php

namespace Gravity\Component\Entity\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Entity
 *
 * @package Gravity\Component\Entity\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class Entity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var FieldData[]
     */
    protected $fields;

    function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return FieldData[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param FieldData $field
     */
    public function addField(FieldData $field)
    {
        $this->fields[] = $field;
        $field->setEntity($this);
    }

    /**
     * @param FieldData $field
     */
    public function removeField(FieldData $field)
    {
        $this->fields->removeElement($field);
    }
}
