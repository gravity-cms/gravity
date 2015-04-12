<?php

namespace Gravity\FileBundle\ImageStyler\Operation\GDOptimiser;

use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\ImageStyler\Operation\GDOptimiser\Configuration\GDOptimiserConfiguration;
use Gravity\FileBundle\ImageStyler\Operation\OperationInterface;
use GravityCMS\Component\Configuration\ConfigurationInterface;

/**
 * Class GDOptimiser
 *
 * @package Gravity\FileBundle\ImageStyler\Operation\GDOptimiser
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class GDOptimiser implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gd_optimiser';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'GD Optimiser';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Optimise images using the GD library';
    }

    /**
     * @return GDOptimiserConfiguration
     */
    public function getConfiguration()
    {
        return new GDOptimiserConfiguration();
    }

    /**
     * @param File                     $file
     * @param GDOptimiserConfiguration $options
     */
    public function process(File $file, ConfigurationInterface $options = null)
    {
        $info = getimagesize($file->getPath());

        switch ($info['mime']) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file->getPath());
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file->getPath());
                break;
            case 'image/png':
                $image = imagecreatefrompng($file->getPath());
                break;
            default:
                return;
                break;
        }

        //save file
        imagejpeg($image, $file->getPath(), $options->getQuality());
    }
}
