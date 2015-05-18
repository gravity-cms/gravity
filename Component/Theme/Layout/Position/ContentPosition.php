<?php

namespace Gravity\Component\Theme\Layout\Position;

/**
 * Class ContentPosition
 *
 * @package Gravity\Component\Theme\Layout\Position
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentPosition implements PositionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'content';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Content';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * (Optional) Default delta of the the position
     *
     * @return int
     */
    public function getDelta()
    {
        return 50;
    }

}
