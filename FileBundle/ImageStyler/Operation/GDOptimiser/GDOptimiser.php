<?php

namespace Gravity\FileBundle\ImageStyler\Operation\GDOptimiser;

use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\ImageStyler\Operation\GDOptimiser\Configuration\GDOptimiserConfiguration;
use Gravity\FileBundle\ImageStyler\Operation\OperationInterface;

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
     * @return Configuration
     */
    public function getConfiguration()
    {
        return new Configuration();
    }

    /**
     * @param File  $file
     * @param array $options
     */
    public function process(File $file, array $options)
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
        imagejpeg($image, $file->getPath(), $options['quality']);
    }
}
