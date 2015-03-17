<?php

namespace Gravity\NodeBundle\Configuration;

use GravityCMS\Component\Configuration\AbstractConfiguration;

/**
 * Class FieldConfiguration
 *
 * @package Gravity\NodeBundle\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class FieldConfiguration extends AbstractConfiguration
{
    const LIMIT_UNLIMITED = -1;

    protected $limit = 1;

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }
} 
