<?php

namespace Gravity\Component\Theme\Layout\Position;

/**
 * Class NavigationPosition
 *
 * @package Gravity\Component\Theme\Layout\Position
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NavigationPosition implements PositionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'navigation';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Navigation';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getDelta()
    {
        return 5;
    }
}
