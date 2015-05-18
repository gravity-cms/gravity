<?php

namespace Gravity\Component\Field\Configuration;

use Gravity\Component\Configuration\AbstractConfiguration;
use Gravity\Component\Field\FieldSettingsInterface;

/**
 * Class FieldConfiguration
 *
 * @package Gravity\Component\Field\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class FieldSettingsConfiguration extends AbstractConfiguration implements FieldSettingsInterface
{
    const LIMIT_UNLIMITED = -1;

    protected $limit = 1;

    protected $required = true;

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

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }
} 
