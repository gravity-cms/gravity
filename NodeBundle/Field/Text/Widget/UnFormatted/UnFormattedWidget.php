<?php

namespace Gravity\NodeBundle\Field\Text\Widget\UnFormatted;

use Gravity\NodeBundle\Entity\FieldText;
use Gravity\NodeBundle\Field\Text\Widget\UnFormatted\Asset\UnFormattedWidgetLibrary;
use Gravity\NodeBundle\Field\Text\Widget\UnFormatted\Configuration\UnFormattedWidgetConfiguration;
use GravityCMS\Component\Field\FieldInterface;
use GravityCMS\Component\Field\Widget\AbstractWidget;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;

/**
 * Class UnFormattedWidget
 *
 * @package Gravity\NodeBundle\Field\Text\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class UnFormattedWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text.unformatted';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'UnFormatted Text Editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Unformatted text box';
    }

    /**
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new UnFormattedWidgetConfiguration();
    }

    public function getForm()
    {
        return new UnFormattedWidgetForm();
    }

    public function getEntityClass()
    {
        return 'Gravity\NodeBundle\Entity\FieldText';
    }

    public function getAssetLibraries()
    {
        return [
            new UnFormattedWidgetLibrary(),
        ];
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
        return ($field->getName() === 'text');
    }

    /**
     * @param FieldText                  $entity
     * @param WidgetSettingsInterface $configuration
     */
    public function setDefaults($entity, WidgetSettingsInterface $configuration)
    {
        $entity->setBody($configuration->getDefault());
    }
}
