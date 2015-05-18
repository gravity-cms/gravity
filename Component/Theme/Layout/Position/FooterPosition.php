<?php

namespace Gravity\Component\Theme\Layout\Position;

/**
 * Class FooterPosition
 *
 * @package Gravity\Component\Theme\Layout\Position
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FooterPosition implements PositionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'footer';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Footer';
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
        return 100;
    }
}
