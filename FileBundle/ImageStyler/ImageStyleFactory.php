<?php


namespace Gravity\FileBundle\ImageStyler;

use Gravity\FileBundle\ImageStyler\Operation\OperationManager;
use Gravity\FileBundle\ImageStyler\Operation\Processor\OperationProcessor;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Parser;

/**
 * Class ImageStyleFactory
 *
 * @package Gravity\FileBundle\ImageStyler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleFactory
{
    /**
     * @var OperationManager
     */
    protected $operationManager;

    function __construct(OperationManager $operationManager)
    {
        $this->operationManager = $operationManager;
    }

    /**
     * @param string $name
     * @param array  $operations
     *
     * @return ImageStyle
     */
    public function createImageStyle($name, array $operations = [])
    {
        $style = new ImageStyle($name);

        $processor = new Processor();

        foreach ($operations as $operationName => $operation) {
            $operationDefinition = $this->operationManager->getOperation($operation['type']);
            $configuration = $operationDefinition->getConfiguration();

            $config = $processor->processConfiguration($configuration,[
                $operation['settings'],
            ]);

            $operationProcessor = new OperationProcessor($operationDefinition, $config);

            $style->addOperationProcessor($operationProcessor);
        }

        return $style;
    }
}
