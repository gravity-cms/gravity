<?php


namespace Gravity\FileBundle\Field\Image\Widget\ImageBrowser;

use Gravity\Component\Field\FieldDefinitionInterface;
use Gravity\Component\Field\Widget\AbstractWidgetDefinition;
use Gravity\FileBundle\Asset\FieldImageLibrary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ImageBrowserWidget
 *
 * @package Gravity\FileBundle\Field\Image\Widget\ImageBrowser
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageBrowserWidget extends AbstractWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'image.image_browser';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Image Browser';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Image Browser';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return 'Gravity\FileBundle\Entity\FieldImage';
    }

    /**
     * Get the form type for this widget
     *
     * @return AbstractType
     */
    public function getForm()
    {
        return new ImageBrowserWidgetForm();
    }

    /**
     * Checks if this widget supports the given field
     *
     * @param FieldDefinitionInterface $field
     *
     * @return string
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return ($field->getName() === 'image');
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setRequired(['image_style']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAssetLibraries()
    {
        return [
            new FieldImageLibrary(),
        ];
    }

}
