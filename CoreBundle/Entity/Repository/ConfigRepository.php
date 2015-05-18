<?php

namespace Gravity\CoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Gravity\CoreBundle\Entity\Config;

/**
 * Class ConfigRepository
 *
 * @package Gravity\CoreBundle\Entity\Repository
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigRepository extends EntityRepository
{
    /**
     * Flush all configs under a name pattern
     *
     * @param string $pattern
     *
     * @return int The number of rows deleted
     */
    public function flushByPattern($pattern)
    {
        $class = $this->getClassName();
        $dql = "
          DELETE FROM
            {$class} c
          WHERE
            c.name LIKE :pattern
        ";

        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('pattern', $pattern);

        return $query->execute();
    }
}
