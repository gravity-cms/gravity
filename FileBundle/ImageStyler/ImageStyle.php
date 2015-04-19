<?php


namespace Gravity\FileBundle\ImageStyler;

use Gravity\FileBundle\ImageStyler\Operation\OperationInterface;
use Gravity\FileBundle\ImageStyler\Operation\Processor\OperationProcessor;

/**
 * Class ImageStyle
 *
 * @package Gravity\FileBundle\ImageStyler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyle
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var OperationProcessor[]
     */
    protected $operationProcessors;

    /**
     * @param string $name
     */
    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return OperationInterface[]
     */
    public function getOperationProcessors()
    {
        return $this->operationProcessors;
    }

    /**
     * @param OperationProcessor $operationProcessor
     */
    public function addOperationProcessor(OperationProcessor $operationProcessor)
    {
        $this->operationProcessors[] = $operationProcessor;
    }
}
