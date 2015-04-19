<?php


namespace Gravity\FileBundle\ImageStyler\Operation;

use Gravity\FileBundle\Entity\File;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class OperationInterface
 *
 * @package Gravity\FileBundle\ImageStyler\Operation
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface OperationInterface
{
    /**
     * Get the operation's config name
     *
     * @return string
     */
    public function getName();

    /**
     * Get the friendly label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get the friendly description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the operation's configuration
     *
     * @return ConfigurationInterface
     */
    public function getConfiguration();

    /**
     * Process the operation
     *
     * @param File  $file
     * @param array $options
     *
     * @return void
     */
    public function process(File $file, array $options);
}
