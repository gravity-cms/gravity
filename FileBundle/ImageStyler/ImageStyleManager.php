<?php


namespace Gravity\FileBundle\ImageStyler;

use Gravity\FileBundle\Entity\ImageStyle;
use Gravity\FileBundle\ImageStyler\Operation\OperationInterface;
use Gravity\FileBundle\ImageStyler\Operation\Processor\OperationProcessor;
use GravityCMS\Component\Configuration\ConfigurationManager;

/**
 * Class ImageStyleManager
 *
 * @package Gravity\FileBundle\ImageStyler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleManager
{
    /**
     * @var OperationInterface[]
     */
    protected $operations;

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

    public function createProcessor(ImageStyle $imageStyle)
    {
        return new OperationProcessor($this, $imageStyle);
    }
}
