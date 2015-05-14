<?php

namespace Gravity\TagBundle\Field\Widget\AutoComplete;

use Gravity\TagBundle\Asset\TagAutoCompleteLibrary;
use Gravity\TagBundle\Entity\FieldTag;
use Gravity\TagBundle\Field\Widget\AutoComplete\Configuration\TagAutoCompleteWidgetConfiguration;
use GravityCMS\Component\Field\FieldDefinitionInterface;
use GravityCMS\Component\Field\Widget\AbstractWidgetDefinition;

class TagAutoCompleteWidget extends AbstractWidgetDefinition
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tag.autocomplete';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Auto Complete Tag Selector';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Tags Using Auto Complete';
    }

    public function getForm()
    {
        return 'field_tag_widget_autocomplete';
    }

    public function getEntityClass()
    {
        return 'Gravity\TagBundle\Entity\FieldTag';
    }

    public function getAssetLibraries()
    {
        return [
            new TagAutoCompleteLibrary(),
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
        return ($field->getName() === 'tag');
    }

    /**
     * @param FieldTag                  $entity
     * @param WidgetSettingsInterface $configuration
     */
    public function setDefaults($entity, WidgetSettingsInterface $configuration)
    {
//        $entity->a
//        $entity->set($configuration->getDefault());
    }

}
