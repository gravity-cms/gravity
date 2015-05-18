<?php


namespace Gravity\FileBundle\Entity\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Gravity\FileBundle\Entity\File;
use Gravity\CoreBundle\Entity\Service\EntityServiceInterface;

/**
 * Class FileEntityService
 *
 * @package Gravity\FileBundle\Entity\Service
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class FileEntityService implements EntityServiceInterface
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $entityRepository;

    function __construct(EntityManager $entityManager)
    {
        $this->entityManager    = $entityManager;
        $this->entityRepository = $entityManager->getRepository('GravityFileBundle:File');
    }

    /**
     * @return EntityRepository
     */
    public function getEntityRepository()
    {
        return $this->entityRepository;
    }

    /**
     * Create a field entity
     *
     * @return File
     */
    public function create()
    {
        return new File();
    }

    /**
     * @param File $entity
     *
     * @return bool
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);

        return true;
    }

    /**
     * Remove an instance of the entity
     *
     * @param object $entity
     *
     * @return bool
     */
    public function remove($entity)
    {
        $this->entityManager->remove($entity);
    }
}
