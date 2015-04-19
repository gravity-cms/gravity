<?php


namespace Gravity\FileBundle\ImageStyler;

use Gravity\FileBundle\ImageStyler\Operation\OperationManager;

/**
 * Class ImageStyleManager
 *
 * @package Gravity\FileBundle\ImageStyler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleManager
{
    /**
     * @var OperationManager
     */
    protected $operationManager = [];

    /**
     * @var ImageStyle[]
     */
    protected $imageStyles = [];

    /**
     * @param OperationManager $operationManager
     */
    function __construct(OperationManager $operationManager)
    {
        $this->operationManager = $operationManager;
    }

    /**
     * @return OperationManager
     */
    public function getOperationManager()
    {
        return $this->operationManager;
    }

    /**
     * @return ImageStyle[]
     */
    public function getImageStyles()
    {
        return $this->imageStyles;
    }

    /**
     * @param $name
     *
     * @return ImageStyle
     */
    public function getImageStyle($name)
    {
        return $this->imageStyles[$name];
    }

    /**
     * @param ImageStyle[] $imageStyles
     */
    public function setImageStyles(array $imageStyles)
    {
        foreach($imageStyles as $imageStyle)
        {
            $this->addImageStyle($imageStyle);
        }

    }

    /**
     * @param ImageStyle $imageStyle
     */
    public function addImageStyle(ImageStyle $imageStyle)
    {
        $this->imageStyles[$imageStyle->getName()] = $imageStyle;
    }


}
