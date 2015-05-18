<?php

namespace Gravity\Component\Entity\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FieldData
 *
 * @package Gravity\Component\Entity\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class FieldData
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $delta;

    /**
     * @var Entity
     */
    protected $entity;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $field;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param Entity $entity
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }
}
