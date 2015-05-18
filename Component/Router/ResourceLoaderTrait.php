<?php

namespace Gravity\Component\Router;

use Gravity\Component\Module\Module;

/**
 * Class ResourceLoaderTrait
 *
 * @package Gravity\Component\Router
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
trait ResourceLoaderTrait
{
    /**
     * All resources
     *
     * @var Module[]
     */
    protected $resources = [];

    /**
     * Array of app module paths
     *
     * @var Module[]
     */
    protected $modules = [];


    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * @param Module $module
     * @param string $resource Resource to load
     */
    public function addModuleResource(Module $module, $resource)
    {
        $this->resources[$module->getName()][] = $resource;
        $this->modules[$module->getName()]     = $module;
    }
}
