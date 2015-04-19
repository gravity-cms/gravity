<?php

namespace Gravity\FileBundle\ImageStyler\Operation\NodeOptimiser;

use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\ImageStyler\Operation\OperationInterface;
use GravityCMS\Component\Configuration\ConfigurationInterface;

/**
 * Use jpegoptim and optipng to optimise images
 *
 * Class NodeOptimiser
 *
 * @package Gravity\FileBundle\ImageStyler\Operation\NodeOptimiser
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeOptimiser implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'node_optimiser';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Node Optimiser';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Use node tools (jpegoptim and optipng) to optimise images';
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function process(File $file, array $options)
    {
        $info = getimagesize($file->getPath());

        switch($info['mime'])
        {
            case 'image/jpeg':
                exec("jpegoptim --strip-all \"{$file->getPath()}\"");
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file->getPath());
                imagepng($image, $file->getPath());
                exec("optipng \"{$file->getPath()}\"");
                break;
            case 'image/png':
                exec("optipng \"{$file->getPath()}\"");
                break;
            default:
                return $file;
                break;
        }

        return $file;
    }
} 
