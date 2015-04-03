<?php

namespace Gravity\NodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GravityCMS\CoreBundle\Entity\FieldData;

/**
 * Class FieldText
 *
 * @package Gravity\NodeBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldText extends FieldData
{
    /**
     * @var string
     */
    protected $body;

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
