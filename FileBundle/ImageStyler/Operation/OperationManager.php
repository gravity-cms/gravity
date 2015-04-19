<?php


namespace Gravity\FileBundle\ImageStyler\Operation;

/**
 * Class OperationManager
 *
 * @package Gravity\FileBundle\ImageStyler\Operation
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class OperationManager
{
    /**
     * @var OperationInterface[]
     */
    protected $operations = [];

    /**
     * @return OperationInterface[]
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * @param OperationInterface[] $operations
     */
    public function setOperations($operations)
    {
        foreach ($operations as $operation) {
            $this->addOperation($operation);
        }
    }

    /**
     * @param OperationInterface $operation
     */
    public function addOperation(OperationInterface $operation)
    {
        $this->operations[$operation->getName()] = $operation;
    }

    /**
     * @param string $name
     *
     * @return OperationInterface
     */
    public function getOperation($name)
    {
        return $this->operations[$name];
    }
}
