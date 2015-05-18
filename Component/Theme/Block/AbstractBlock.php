<?php

namespace Gravity\Component\Theme\Block;

/**
 * Class AbstractBlock
 *
 * @package Gravity\Component\Block
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractBlock implements BlockInterface
{
    public function getParent()
    {
        return 'root';
    }
}
