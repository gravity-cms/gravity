<?php

namespace Gravity\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Group
 *
 * @package Gravity\CoreBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Group extends BaseGroup
{
    /**
     * @var Role[]
     */
    protected $roles;

    /**
     * @var User[]
     */
    protected $users;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function getRolesAsCollection()
    {
        return $this->roles;
    }

}
