<?php

namespace Gravity\Component\Router;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

class AdminLoader extends Loader
{
    use ResourceLoaderTrait;

    /**
     * Array of app plugin paths
     *
     * @var string
     */
    private $adminPath = '/';

    /**
     * @return string
     */
    public function getAdminPath()
    {
        return $this->adminPath;
    }

    /**
     * @param string $adminPath
     */
    public function setAdminPath($adminPath)
    {
        $this->adminPath = $adminPath;
    }

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
        $moduleRoutes   = new RouteCollection();

        if ($resource == '.') {
            if($this->loaded){
                throw new \Exception("Can only load gravity_admin route once");
            }
            $this->loaded = true;

            foreach($this->resources as $moduleName => $routeResources) {
                $module = $this->modules[$moduleName];
                foreach ($routeResources as $resource) {
                    $resourceRoutes = $this->import($resource);
                    $resourceRoutes->addPrefix($module->getName());
                    $moduleRoutes->addCollection($resourceRoutes);
                }
            }
        } else {
            $resourceRoutes = $this->import($resource);
            $moduleRoutes->addCollection($resourceRoutes);
        }

        $routes = new RouteCollection();
        // prefix all the routes with the plugin base
        foreach ($moduleRoutes->all() as $name => $route) {
            $routes->add('gravity_admin_' . $name, $route);
        }

        if ($this->adminPath) {
            $routes->addPrefix($this->adminPath);
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
        return 'gravity_admin' === $type;
    }


}
