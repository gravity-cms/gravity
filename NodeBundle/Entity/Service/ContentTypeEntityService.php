<?php


namespace Gravity\NodeBundle\Entity\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Gravity\NodeBundle\Entity\ContentType;
use GravityCMS\CoreBundle\Entity\Service\EntityServiceInterface;

/**
 * Class ContentTypeEntityService
 *
 * @package Gravity\NodeBundle\Entity\Service
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ContentTypeEntityService implements EntityServiceInterface
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
        $this->entityRepository = $entityManager->getRepository('GravityNodeBundle:ContentType');
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
     * @return ContentType
     */
    public function create()
    {
        return new ContentType();
    }

    /**
     * @param ContentType $entity
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
