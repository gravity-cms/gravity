<?php

namespace Gravity\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gravity\Component\Theme\Entity\LayoutPositionBlock as LayoutPositionBlockModel;

/**
 * Class LayoutPositionBlock
 *
 * @package Gravity\CoreBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class LayoutPositionBlock extends LayoutPositionBlockModel
{
    /**
     * @var Layout
     */
    protected $layout;

    /**
     * @var LayoutPosition
     */
    protected $position;

    /**
     * @var Block
     */
    protected $block;
}
