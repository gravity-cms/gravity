<?php

namespace Gravity\CoreBundle\Field\Text\Widget\UnFormatted;

use Gravity\Component\Field\FieldDefinitionInterface;
use Gravity\Component\Field\FieldInterface;
use Gravity\Component\Field\Widget\AbstractWidget;
use Gravity\Component\Field\Widget\AbstractWidgetDefinition;
use Gravity\Component\Field\Widget\WidgetSettingsInterface;
use Gravity\CoreBundle\Field\Text\Widget\UnFormatted\Asset\UnFormattedWidgetLibrary;
use Gravity\CoreBundle\Field\Text\Widget\UnFormatted\Configuration\UnFormattedWidgetConfiguration;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UnFormattedWidget
 *
 * @package Gravity\CoreBundle\Field\Text\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class UnFormattedWidget extends AbstractWidgetDefinition
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

    public function getForm()
    {
        return new UnFormattedWidgetForm();
    }

    public function getEntityClass()
    {
        return 'Gravity\CoreBundle\Entity\FieldText';
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
     * @param FieldDefinitionInterface $field
     *
     * @return string
     */
    public function supportsField(FieldDefinitionInterface $field)
    {
        return ($field->getName() === 'text');
    }

    //    /**
    //     * @param FieldText                  $entity
    //     * @param WidgetSettingsInterface $configuration
    //     */
    //    public function setDefaults($entity, WidgetSettingsInterface $configuration)
    //    {
    //        $entity->setBody($configuration->getDefault());
    //    }

    public function setOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            [
                'multiline' => false,
            ]
        );
    }


}
