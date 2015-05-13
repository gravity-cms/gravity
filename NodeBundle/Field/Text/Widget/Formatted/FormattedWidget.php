<?php

namespace Gravity\NodeBundle\Field\Text\Widget\Formatted;

use Gravity\NodeBundle\Entity\FieldText;
use Gravity\NodeBundle\Field\Text\Widget\Formatted\Asset\FormattedWidgetLibrary;
use Gravity\NodeBundle\Field\Text\Widget\Formatted\Configuration\FormattedWidgetConfiguration;
use GravityCMS\Component\Field\FieldInterface;
use GravityCMS\Component\Field\Widget\AbstractWidget;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;

/**
 * Class FormattedWidget
 *
 * @package Gravity\NodeBundle\Field\Text\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FormattedWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text.formatted';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Formatted Text Editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'WYSIWYG editor for formatted text';
    }

    /**
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new FormattedWidgetConfiguration();
    }

    public function getForm()
    {
        return new FormattedWidgetForm();
    }

    public function getEntityClass()
    {
        return 'Gravity\NodeBundle\Entity\FieldText';
    }

    public function getAssetLibraries()
    {
        return [
            new FormattedWidgetLibrary(),
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
