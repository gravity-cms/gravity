<?php

namespace Gravity\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FieldChoice
 *
 * @package Gravity\CoreBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldChoice extends FieldData
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }
}
