<?php


namespace Gravity\CoreBundle\Entity\Service;

use Doctrine\ORM\EntityRepository;

/**
 * Class EntityService
 *
 * @package Gravity\CoreBundle\Entity\Service
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
interface EntityServiceInterface
{
    /**
     * Get the entity repository
     *
     * @return EntityRepository
     */
    public function getEntityRepository();

    /**
     * Create a new instance of the entity
     *
     * @return object
     */
    public function create();

    /**
     * Persist an instance of an entity
     *
     * @param object $entity
     *
     * @return bool
     */
    public function persist($entity);

    /**
     * Remove an instance of the entity
     *
     * @param object $entity
     *
     * @return bool
     */
    public function remove($entity);
}
