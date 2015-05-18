<?php

namespace Gravity\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gravity\Component\Theme\Entity\LayoutPosition as LayoutPositionModel;

/**
 * Class LayoutPosition
 *
 * @package Gravity\CoreBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class  LayoutPosition extends LayoutPositionModel
{
    /**
     * @var LayoutPositionBlock[]
     */
    protected $layouts;
}
