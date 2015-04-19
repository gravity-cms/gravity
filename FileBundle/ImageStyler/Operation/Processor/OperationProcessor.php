<?php


namespace Gravity\FileBundle\ImageStyler\Operation\Processor;

use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\Entity\ImageStyle;
use Gravity\FileBundle\ImageStyler\ImageStyleManager;
use Gravity\FileBundle\ImageStyler\Operation\OperationInterface;

/**
 * Class OperationProcessor
 *
 * @package Gravity\FileBundle\ImageStyler\Operation\Processor
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class OperationProcessor
{
    /**
     * @var OperationInterface
     */
    protected $operation;

    /**
     * @var array
     */
    protected $settings;

    function __construct(OperationInterface $operation, array $settings)
    {
        $this->operation = $operation;
        $this->settings = $settings;
    }

    /**
     * @return OperationInterface
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Process a base image into a style
     *
     * @param File $file
     */
    public function process(File $file)
    {
        $this->operation->process($file, $this->settings);
    }

}
