<?php

namespace Gravity\Component\Theme\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Block
 *
 * @package Gravity\Component\Theme\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class BlockData
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
