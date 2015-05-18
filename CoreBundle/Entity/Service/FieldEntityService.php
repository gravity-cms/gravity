<?php


namespace Gravity\CoreBundle\Entity\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Gravity\Component\Field\Configuration\FieldSettingsConfiguration;
use Gravity\Component\Field\FieldManager;
use Gravity\CoreBundle\Entity\Field;
use Gravity\CoreBundle\Entity\FieldDisplay;
use Gravity\CoreBundle\Entity\FieldWidget;

/**
 * Class FieldEntityService
 *
 * @package Gravity\CoreBundle\Entity\Service
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldEntityService implements EntityServiceInterface
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

    function __construct(EntityManager $entityManager, FieldManager $fieldManager)
    {
        $this->entityManager    = $entityManager;
        $this->entityRepository = $entityManager->getRepository('GravityCoreBundle:Field');
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
        return new Field();
    }

    /**
     * @param Field $entity
     *
     * @return bool
     */
    public function persist($entity)
    {
        $fieldDefinition = $this->fieldManager->getField($entity->getFieldType());

        if (!$entity->getName()) {
            $name = str_replace(' ', '_', $entity->getLabel());
            $name = strtolower(preg_replace('/[^\w_]/', '', $name));
            $entity->setName($name);
        }

        if (!$entity->getConfig() instanceof FieldSettingsConfiguration) {
            $configClass   = $fieldDefinition->getSettings();
            $defaultConfig = new $configClass();
            $entity->setConfig($defaultConfig);
        }

        if (!$entity->getDisplay() instanceof FieldDisplay) {
            $fieldDisplay = $fieldDefinition->getDisplay();
            $viewDisplay  = new FieldDisplay();
            $viewDisplay->setName($fieldDisplay->getName());
            $viewDisplay->setLabel($fieldDisplay->getLabel());
            $viewDisplay->setConfig($fieldDisplay->getSettings());
            $viewDisplay->setDelta(0);
            $this->entityManager->persist($viewDisplay);
            $entity->setDisplay($viewDisplay);
        }

        if (!$entity->getWidget() instanceof FieldWidget) {
            $fieldWidget = $fieldDefinition->getWidget();
            $viewWidget  = new FieldWidget();
            $viewWidget->setName($fieldWidget->getName());
            $viewWidget->setLabel($fieldWidget->getLabel());
            $viewWidget->setConfig($fieldWidget->getSettings());
            $viewWidget->setDelta(0);
            $this->entityManager->persist($viewWidget);
            $entity->setWidget($viewWidget);
        }

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
