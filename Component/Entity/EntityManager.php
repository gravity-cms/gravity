<?php

namespace Gravity\Component\Entity;

use Gravity\Component\Entity\Definition\EntityDefinitionInterface;

/**
 * Class EntityManager
 *
 * @package Gravity\Component\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class EntityManager
{
    /**
     * @var EntityDefinitionInterface[]
     */
    protected $entityDefinitions = [];

    /**
     * @return EntityDefinitionInterface[]
     */
    public function getEntityDefinitions()
    {
        return $this->entityDefinitions;
    }

    /**
     * @param EntityDefinitionInterface[] $entityDefinitions
     */
    public function setEntityDefinitions(array $entityDefinitions)
    {
        foreach($entityDefinitions as $entityDefinition)
        {
            $this->addEntityDefinition($entityDefinition);
        }
    }

    /**
     * @param EntityDefinitionInterface $entityDefinition
     */
    public function addEntityDefinition(EntityDefinitionInterface $entityDefinition)
    {
        $this->entityDefinitions[] = $entityDefinition;
    }

    /**
     * @param string $entityDefinitionName
     *
     * @return EntityDefinitionInterface
     */
    public function getEntityDefiniton($entityDefinitionName)
    {
        return $this->entityDefinitions[$entityDefinitionName];
    }
}
