<?php

namespace Gravity\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gravity\Component\Theme\Entity\Block as BlockModel;

/**
 * Class Block
 *
 * @package Gravity\CoreBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Block extends BlockModel
{
    /**
     * @var LayoutPositionBlock[]
     */
    protected $layoutPositions;

}
