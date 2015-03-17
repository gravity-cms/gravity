<?php

namespace Gravity\NodeBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ContentTypeFieldRepository extends EntityRepository
{
    public function findWithField($id)
    {
        $query = $this->createQueryBuilder('ctf')
            ->select('ctf, f')
            ->leftJoin('ctf.field', 'f')
            ->where('ctf.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
        ;

        return $query->getResult();
    }
} 
