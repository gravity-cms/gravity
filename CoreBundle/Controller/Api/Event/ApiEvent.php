<?php

namespace Gravity\CoreBundle\Controller\Api\Event;

use Gravity\Component\Configuration\ConfigurationInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ApiEvent
 *
 * @package Gravity\CoreBundle\Controller\Api\Event
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ApiEvent extends Event
{
    /**
     * @var object
     */
    protected $entity;

    function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return object
     */
    public function getEntity()
    {
        return $this->entity;
    }

}
