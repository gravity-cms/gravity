<?php

namespace Gravity\NodeBundle\Doctrine\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use GravityCMS\Component\Configuration\ConfigurationManager;
use Gravity\NodeBundle\Entity\ContentType;
use Gravity\NodeBundle\Entity\ContentTypeField;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ContentTypeEventListener
 *
 * @package Gravity\NodeBundle\Doctrine\EventListener
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentTypeEventListener implements EventSubscriber
{
    /**
     * @var ConfigurationManager
     */
    protected $configManager;

    /**
     * @var array
     */
    protected $updatedContentTypes;

    /**
     * @var ContainerInterface
     */
    protected $container;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::onFlush,
            Events::postPersist,
            Events::postRemove,
        );
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        $this->getConfigurationManager();
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof ContentType) {
                $changeSet = $uow->getEntityChangeSet($entity);
                if (isset($changeSet['name'])) {
                    list($oldValue, $newValue) = $changeSet['name'];
                    foreach ($entity->getContentTypeFields() as $field) {
                        $oldFieldConfigName = 'content_type.' . $oldValue . '.' . $field->getName();
                        $newFieldConfigName = 'content_type.' . $newValue . '.' . $field->getName();

                        $this->configManager->rename($oldFieldConfigName, $newFieldConfigName);
                    }
                }
            }

            if($entity instanceof ContentTypeField){
                $changeSet = $uow->getEntityChangeSet($entity);
                if (isset($changeSet['name'])) {
                    list($oldValue, $newValue) = $changeSet['name'];
                    $oldFieldConfigName = 'content_type.' . $entity->getContentType()->getName() . '.' . $oldValue;
                    $newFieldConfigName = 'content_type.' . $entity->getContentType()->getName() . '.' . $newValue;

                    $this->configManager->rename($oldFieldConfigName, $newFieldConfigName);
                }
            }
        }

    }

    /**
     * On post-persist, create a config entry
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof ContentType) {
            $this->getConfigurationManager();
            foreach ($entity->getContentTypeFields() as $field) {
                $fieldConfigName = 'content_type.' . $entity->getName() . '.' . $field->getName();
                $this->configManager->duplicate($field->getField()->getName() . '.settings', $fieldConfigName);
            }
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof ContentType) {
            $this->getConfigurationManager();
            foreach ($entity->getContentTypeFields() as $field) {
                $fieldConfigName = 'content_type.' . $entity->getName() . '.' . $field->getName();
                $this->configManager->delete($fieldConfigName);
            }
        }
    }

    protected function getConfigurationManager()
    {
        return $this->configManager = $this->container->get('gravity_cms.configuration_manager');
    }

} 
