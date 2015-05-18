<?php

namespace Gravity\Component\Theme\View;

use Gravity\Component\Theme\View\Configuration\AbstractViewConfiguration;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ViewInterface
 *
 * Views are the base components of a page. A view is tied to an entity, and can be assigned blocks to render.
 *
 * @package Gravity\Component\Theme\View
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface ViewInterface
{
    /**
     * Get the name of the view
     *
     * @return string
     */
    public function getName();

    /**
     * Get a friendly name of the view
     *
     * @return string
     */
    public function getLabel();

    /**
     * Verify this view supports this request
     *
     * @param Request $request
     * @param object  $entity
     *
     * @return boolean
     */
    public function supports(Request $request, $entity);

    /**
     * @return AbstractViewConfiguration
     */
    public function getConfiguration();

    /**
     * Handle a request, return a response
     *
     * @param Request $request Request Object
     * @param object  $entity  Entity Object
     *
     * @return mixed
     */
    public function handle(Request $request, $entity);

    /**
     * Handle a request to list an entity
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function handleList(Request $request);

    /**
     * Get a list of zone names for this view
     *
     * @return array
     */
    public function getZones();
}
