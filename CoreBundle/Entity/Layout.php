<?php

namespace Gravity\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gravity\Component\Theme\Entity\Layout as LayoutModel;

/**
 * Class Layout
 *
 * @package Gravity\CoreBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Layout extends LayoutModel
{
    /**
     * @var LayoutPositionBlock[]
     */
    protected $positions;
}
