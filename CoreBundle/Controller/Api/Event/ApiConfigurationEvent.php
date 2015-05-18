<?php

namespace Gravity\CoreBundle\Controller\Api\Event;

use Gravity\Component\Configuration\ConfigurationInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ApiConfigurationEvent
 *
 * @package Gravity\CoreBundle\Controller\Api\Event
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ApiConfigurationEvent extends Event
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;

    function __construct(ConfigurationInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return ConfigurationInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

}
