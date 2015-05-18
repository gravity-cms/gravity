<?php

namespace Gravity\Component\Entity\Definition;

/**
 * Interface EntityDefinitionInterface
 *
 * @package Gravity\Component\Entity\Definition
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface EntityDefinitionInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getLabel();

    public function getListController();

    public function getDisplayController();
}
