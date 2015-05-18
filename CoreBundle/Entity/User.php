<?php

namespace Gravity\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="security_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var Group[]
     */
    protected $groups;

    /**
     * @var Role[]
     */
    protected $rolesAsCollection;

    public function __construct()
    {
        parent::__construct();

        $this->rolesAsCollection = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    function __toString()
    {
        return $this->username;
    }

    /**
     * @return Role[]
     */
    public function getRolesAsCollection()
    {
        return $this->rolesAsCollection;
    }

    /**
     * @param Role[] $rolesAsCollection
     */
    public function setRolesAsCollection(array $rolesAsCollection)
    {
        $this->rolesAsCollection = $rolesAsCollection;
    }



}
