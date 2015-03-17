<?php

namespace Gravity\NodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FieldText
 *
 * @package Gravity\NodeBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldText extends NodeContent
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
