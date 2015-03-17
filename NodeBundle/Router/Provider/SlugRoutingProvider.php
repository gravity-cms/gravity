<?php

namespace Gravity\NodeBundle\Router\Provider;

use Gravity\NodeBundle\Router\RoutingProviderInterface;
use Symfony\Component\Routing\Route;

/**
 * Class SlugRoutingProvider
 *
 * @package Gravity\NodeBundle\Router\Provider
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SlugRoutingProvider implements RoutingProviderInterface
{
    /**
     * Get the route
     *
     * @return string
     */
    public function getRoute()
    {
        return new Route('');
    }
}
