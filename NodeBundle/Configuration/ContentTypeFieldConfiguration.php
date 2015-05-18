<?php

namespace Gravity\NodeBundle\Configuration;

use Gravity\Component\Configuration\AbstractConfiguration;

/**
 * Class ContentTypeFieldConfiguration
 *
 * @package Gravity\NodeBundle\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class ContentTypeFieldConfiguration extends AbstractConfiguration
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
