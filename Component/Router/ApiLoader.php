<?php

namespace Gravity\Component\Router;

use Gravity\Component\Plugin\Plugin;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

class ApiLoader extends Loader
{
    use ResourceLoaderTrait;

    /**
     * Load all resources into the router
     *
     * @param mixed $resource
     * @param null  $type
     *
     * @return RouteCollection
     * @throws \Exception
     */
    public function load($resource, $type = null)
    {

        $moduleRoutes = new RouteCollection();
        if ($resource === '.') {
            if ($this->loaded) {
                throw new \Exception("Can only load gravity_admin route once");
            }
            $this->loaded = true;

            foreach ($this->resources as $moduleName => $routeResources) {
                foreach ($routeResources as $resource) {
                    $resourceRoutes = $this->import($resource);
                    $moduleRoutes->addCollection($resourceRoutes);
                }
            }
        } else {
            $resourceRoutes = $this->import($resource, 'rest');
            $moduleRoutes->addCollection($resourceRoutes);
        }

        $routes = new RouteCollection();
        // prefix all the routes with the plugin base
        foreach ($moduleRoutes->all() as $name => $route) {
            $routes->add('gravity_api_' . $name, $route);
        }

        $routes->addPrefix('/api');

        return $routes;
    }

    /**
     * @param mixed $resource
     * @param null  $type
     *
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return 'gravity_api' === $type;
    }


}
