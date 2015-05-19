<?php

namespace Gravity\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FieldBoolean
 *
 * @package Gravity\CoreBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldBoolean extends FieldData
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
