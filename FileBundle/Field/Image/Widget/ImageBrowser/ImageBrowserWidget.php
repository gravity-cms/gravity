<?php


namespace Gravity\FileBundle\Field\Image\Widget\ImageBrowser;

use Gravity\FileBundle\Asset\FieldImageLibrary;
use Gravity\FileBundle\Field\Image\Widget\ImageBrowser\Configuration\ImageBrowserWidgetConfiguration;
use GravityCMS\Component\Field\FieldInterface;
use GravityCMS\Component\Field\Widget\AbstractWidget;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Class ImageBrowserWidget
 *
 * @package Gravity\FileBundle\Field\Image\Widget\ImageBrowser
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ImageBrowserWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.file.widget.image_browser';
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
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new ImageBrowserWidgetConfiguration();
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
     * @param FieldInterface $field
     *
     * @return string
     */
    public function supportsField(FieldInterface $field)
    {
        return ($field->getName() === 'image');
    }

    public function getAssetLibraries()
    {
        return [
            new FieldImageLibrary(),
        ];
    }

}
