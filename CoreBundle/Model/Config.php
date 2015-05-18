<?php

namespace Gravity\CoreBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gravity\Component\Configuration\ConfigurationInterface;

/**
 * Class Config
 *
 * @package Gravity\CoreBundle\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Config
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var string
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param ConfigurationInterface $value
     */
    public function setValue(ConfigurationInterface $value)
    {
        $this->value = $value;
    }
}
