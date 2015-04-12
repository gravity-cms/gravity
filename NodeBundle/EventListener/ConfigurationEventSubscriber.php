<?php

namespace Gravity\NodeBundle\EventListener;

use Doctrine\ORM\EntityManager;
use GravityCMS\Component\Configuration\ConfigurationManager;
use Gravity\NodeBundle\Entity\ContentType;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ConfigurationEventListener
 *
 * @package Gravity\NodeBundle\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigurationEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var ConfigurationManager
     */
    protected $configManager;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    function __construct(ConfigurationManager $configManager, EntityManager $entityManager)
    {
        $this->configManager = $configManager;
        $this->entityManager = $entityManager;
    }


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
//            ConfigurationManager::CONFIG_BUILD => array(
//                array('onConfigRebuild', 10),
//            )
        );
    }

    public function onConfigRebuild(Event $event)
    {
        /** @var ContentType[] $contentTypes */
        $contentTypes = $this->entityManager->getRepository('GravityNodeBundle:ContentType')->findAll();

        foreach ($contentTypes as $contentType) {
            $fields = $contentType->getFields();
            foreach ($fields as $field) {
                $configType = 'field.' . $field->getName();
                $configName = 'content_type.' . $contentType->getName() . '.' . $field->getName();
                $this->configManager->create($configType, $configName);
            }
        }
    }


}
