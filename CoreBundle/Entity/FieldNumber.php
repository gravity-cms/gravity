<?php


namespace Gravity\CoreBundle\Entity;

/**
 * Class FieldNumber
 *
 * @package Gravity\CoreBundle\Entity
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class FieldNumber extends FieldData
{
    /**
     * @var int|float
     */
    protected $number;

    /**
     * @return float|int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param float|int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }
}
