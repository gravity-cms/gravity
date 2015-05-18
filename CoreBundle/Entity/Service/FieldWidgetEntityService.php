<?php


namespace Gravity\CoreBundle\Entity\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Gravity\Component\Field\FieldManager;
use Gravity\CoreBundle\Entity\Field;
use Gravity\CoreBundle\Entity\FieldWidget;

/**
 * Class FieldEntityService
 *
 * @package Gravity\CoreBundle\Entity\Service
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldWidgetEntityService implements EntityServiceInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $entityRepository;

    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @param EntityManager $entityManager
     * @param FieldManager  $fieldManager
     */
    function __construct(EntityManager $entityManager, FieldManager $fieldManager)
    {
        $this->entityManager    = $entityManager;
        $this->entityRepository = $entityManager->getRepository('GravityCoreBundle:FieldWidget');
        $this->fieldManager     = $fieldManager;
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
     * @return Field
     */
    public function create()
    {
        return new FieldWidget();
    }

    /**
     * @param FieldWidget $entity
     *
     * @return bool
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);

        return true;
    }


    public function updateType(FieldWidget $field, $newWidgetType)
    {
        $widget = $this->fieldManager->getFieldWidget($newWidgetType);

        $field->setConfig($widget->getSettings());
        $field->setName($widget->getName());
        $field->setLabel($widget->getLabel());
        $field->setDescription($widget->getDescription());
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
