<?php

namespace Gravity\FileBundle\ImageStyler\Operation\Resizer;

use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\ImageStyler\Operation\OperationInterface;

/**
 * Resize image class will allow you to resize an image
 *
 * Can resize to exact size
 * Max width size while keep aspect ratio
 * Max height size while keep aspect ratio
 * Automatic while keep aspect ratio
 */
class ImageResize implements OperationInterface
{
    const RESIZE_DEFAULT    = 0;
    const RESIZE_EXACT      = 1;
    const RESIZE_MAX_WIDTH  = 2;
    const RESIZE_MAX_HEIGHT = 3;

    private $ext;
    private $image;
    private $newImage;
    private $origWidth;
    private $origHeight;
    private $resizeWidth;
    private $resizeHeight;

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function getLabel()
    {
        // TODO: Implement getLabel() method.
    }

    public function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    public function operate(File $file)
    {
        // TODO: Implement operate() method.
    }

    /**
     * Save the image as the image type the original image was
     *
     * @param  string $savePath     - The path to store the new image
     * @param  string $imageQuality - The qulaity level of image to create
     *
     * @param bool    $download
     *
     * @return null Saves the image
     */
    public function saveImage($savePath, $imageQuality = "100", $download = false)
    {
        if(!$this->newImage)
        {
            return;
        }

        switch($this->ext)
        {
            case 'image/jpg':
            case 'image/jpeg':
                // Check PHP supports this file type
                if(imagetypes() & IMG_JPG)
                {
                    imagejpeg($this->newImage, $savePath, $imageQuality);
                }
                break;

            case 'image/gif':
                // Check PHP supports this file type
                if(imagetypes() & IMG_GIF)
                {
                    imagegif($this->newImage, $savePath);
                }
                break;

            case 'image/png':
                $invertScaleQuality = 9 - round(($imageQuality / 100) * 9);

                // Check PHP supports this file type
                if(imagetypes() & IMG_PNG)
                {
                    imagepng($this->newImage, $savePath, $invertScaleQuality);
                }
                break;
        }

        if($download)
        {
            header('Content-Description: File Transfer');
            header("Content-type: application/octet-stream");
            header("Content-disposition: attachment; filename= " . $savePath . "");
            readfile($savePath);
        }

        imagedestroy($this->newImage);
    }

    /**
     * Resize the image to these set dimensions
     *
     * @param  int $width        - Max width of the image
     * @param  int $height       - Max height of the image
     * @param  int $resizeOption - Scale option for the image
     *
     * @return null Save new image
     */
    public function resizeTo($width, $height, $resizeOption = ImageResize::RESIZE_DEFAULT)
    {
        switch(strtolower($resizeOption))
        {
            case self::RESIZE_EXACT:
                $this->resizeWidth  = $width;
                $this->resizeHeight = $height;
                break;

            case self::RESIZE_MAX_WIDTH:
                $this->resizeWidth  = $width;
                $this->resizeHeight = $this->resizeHeightByWidth($width);
                break;

            case self::RESIZE_MAX_HEIGHT:
                $this->resizeWidth  = $this->resizeWidthByHeight($height);
                $this->resizeHeight = $height;
                break;

            default:
                if($this->origWidth > $width || $this->origHeight > $height)
                {
                    if($this->origWidth > $this->origHeight)
                    {
                        $this->resizeHeight = $this->resizeHeightByWidth($width);
                        $this->resizeWidth  = $width;
                    }
                    else if($this->origWidth < $this->origHeight)
                    {
                        $this->resizeWidth  = $this->resizeWidthByHeight($height);
                        $this->resizeHeight = $height;
                    }
                }
                else
                {
                    $this->resizeWidth  = $width;
                    $this->resizeHeight = $height;
                }
                break;
        }

        if($this->resizeWidth > 0 && $this->resizeHeight > 0)
        {
            $this->newImage = @imagecreatetruecolor(ceil($this->resizeWidth), ceil($this->resizeHeight));
            @imagecopyresampled($this->newImage, $this->image, 0, 0, 0, 0, $this->resizeWidth, $this->resizeHeight, $this->origWidth, $this->origHeight);
        }
    }

    /**
     * Set the image variable by using image create
     *
     * @param string $filename - The image filename
     *
     * @throws \Exception
     */
    private function setImage($filename)
    {
        $size      = getimagesize($filename);
        $this->ext = $size['mime'];

        switch($this->ext)
        {
            // Image is a JPG
            case 'image/jpg':
            case 'image/jpeg':
                // create a jpeg extension
                $this->image = imagecreatefromjpeg($filename);
                break;

            // Image is a GIF
            case 'image/gif':
                $this->image = @imagecreatefromgif($filename);
                break;

            // Image is a PNG
            case 'image/png':
                $this->image = @imagecreatefrompng($filename);
                break;

            // Mime type not found
            default:
                throw new \Exception("File is not an image, please use another file type.", 1);
        }

        $this->origWidth  = imagesx($this->image);
        $this->origHeight = imagesy($this->image);
    }

    /**
     * Get the resized height from the width keeping the aspect ratio
     *
     * @param  int $width - Max image width
     *
     * @return int Height keeping aspect ratio
     */
    private function resizeHeightByWidth($width)
    {
        return floor(($this->origHeight / $this->origWidth) * $width);
    }

    /**
     * Get the resized width from the height keeping the aspect ratio
     *
     * @param  int $height - Max image height
     *
     * @return int Width keeping aspect ratio
     */
    private function resizeWidthByHeight($height)
    {
        return floor(($this->origWidth / $this->origHeight) * $height);
    }

    /**
     * @return mixed
     */
    public function getOrigHeight()
    {
        return $this->origHeight;
    }

    /**
     * @return mixed
     */
    public function getOrigWidth()
    {
        return $this->origWidth;
    }

    /**
     * @return mixed
     */
    public function getResizeHeight()
    {
        return $this->resizeHeight;
    }

    /**
     * @return mixed
     */
    public function getResizeWidth()
    {
        return $this->resizeWidth;
    }


}

?>
