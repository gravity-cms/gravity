<?php

namespace Gravity\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gravity\CoreBundle\Model\Config as BaseConfig;

/**
 * @ORM\Entity
 * @ORM\Table(name="config")
 */
class Config extends BaseConfig
{
}
