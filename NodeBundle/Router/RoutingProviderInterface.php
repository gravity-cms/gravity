<?php

namespace Gravity\NodeBundle\Router;

/**
 * Class RoutingProvider
 *
 * @package Gravity\NodeBundle\Router
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface RoutingProviderInterface
{
    /**
     * Get the route
     *
     * @return string
     */
    public function getRoute();
} 
