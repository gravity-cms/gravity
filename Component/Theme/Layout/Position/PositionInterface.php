<?php

namespace Gravity\Component\Theme\Layout\Position;

/**
 * Interface PositionInterface
 *
 * @package Gravity\Component\Theme\Layout\Position
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface PositionInterface
{
    /**
     * Returns a string identifier for a position
     *
     * @return string
     */
    public function getName();

    /**
     * Returns a string label for a position
     *
     * @return string
     */
    public function getLabel();

    /**
     * (Optional) Returns a string descriptiopn of the position
     *
     * @return string
     */
    public function getDescription();

    /**
     * (Optional) Default delta of the the position
     *
     * @return int
     */
    public function getDelta();
}
