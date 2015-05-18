<?php

namespace Gravity\Component\Router;

use Gravity\Component\Plugin\Plugin;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Yaml\Parser;

class WebLoader extends Loader
{
    /**
     * All resources
     *
     * @var array[]
     */
    private $resources = array();

    /**
     * Array of app plugin paths
     *
     * @var Plugin[]
     */
    private $plugins = array();

    /**
     * Add a resource to the stack
     *
     * @param string $resource
     * @param Plugin $plugin
     *
     * @internal param $name
     */
    public function addPluginResource(Plugin $plugin, $resource)
    {
        $this->resources[$plugin->getName()][] = $resource;
        $this->plugins[$plugin->getName()] = $plugin;
    }

    /**
     * Load all resources into the router
     *
     * @param mixed $resource
     * @param null  $type
     *
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        $routes = new RouteCollection();

        foreach($this->resources as $pluginName => $routeResources)
        {
            $plugin = $this->plugins[$pluginName];
            $pluginRoutes = new RouteCollection();
            foreach($routeResources as $routeResource)
            {
                $resourceRoutes = $this->import($routeResource);
                $pluginRoutes->addCollection($resourceRoutes);
            }

            // prefix all the routes with the plugin base
            foreach($pluginRoutes->all() as $name => $route)
            {
                $defaultController = $route->getDefault('_controller');
                list($controller, $method) = explode(':', $defaultController);
                $controller = $plugin->getNamespace().'\\Controller\\'.$controller.'Controller';
                $route->setDefault('_controller', $controller.'::'.$method.'Action');
                $routes->add('gravity_module_' . $pluginName . '_' . $name, $route);
            }
        }

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
        return 'gravity_web' === $type;
    }


}
