<?php


namespace Gravity\FileBundle\ImageStyler\Operation\Processor;

use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\Entity\ImageStyle;
use Gravity\FileBundle\ImageStyler\ImageStyleManager;

/**
 * Class OperationProcessor
 *
 * @package Gravity\FileBundle\ImageStyler\Operation\Processor
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class OperationProcessor
{

    /**
     * @var ImageStyle
     */
    protected $imageStyle;

    /**
     * @var ImageStyleManager
     */
    protected $imageStyleManager;

    function __construct(ImageStyleManager $imageStyleManager, ImageStyle $imageStyle)
    {
        $this->imageStyle        = $imageStyle;
        $this->imageStyleManager = $imageStyleManager;
    }

    /**
     * Process a base image into a style
     *
     * @param File $file
     */
    public function process(File $file)
    {
        foreach ($this->imageStyle->getOperations() as $operationDefinition) {
            $operation = $this->imageStyleManager->getOperation($operationDefinition->getName());
            $operation->operate($file);
        }
    }

}
