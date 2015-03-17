<?php

namespace Gravity\NodeBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ContentTypeRepository extends EntityRepository
{
    public function findWithFields($id)
    {
        $query = $this->createQueryBuilder('ct')
            ->select('ct, tf')
            ->leftJoin('ct.typeFields', 'tf')
            ->where('ct.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
        ;

        return $query->getSingleResult();
    }
} 
