<?php

namespace Gravity\Component\Theme\Block;

use Gravity\Component\Theme\Block\Configuration\AbstractBlockConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface BlockInterface
 *
 * @package Gravity\Component\Block
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface BlockInterface
{
    /**
     * Get the block type (the identifier for this block)
     *
     * @return string
     */
    public function getType();

    /**
     * Get the block name
     *
     * @return string
     */
    public function getName();

    /**
     * Get the block description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the block's entity form
     *
     * @return string|AbstractType
     */
    public function getForm();

    /**
     * Fetch the template name
     *
     * @param Request $request
     * @param object  $entity
     *
     * @return string
     */
    public function render(Request $request, $entity);
}
