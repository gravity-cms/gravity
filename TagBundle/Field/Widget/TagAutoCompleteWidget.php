<?php

namespace Gravity\TagBundle\Field\Widget;

use Gravity\TagBundle\Asset\TagAutoCompleteLibrary;
use GravityCMS\Component\Field\FieldInterface;
use GravityCMS\Component\Field\Widget\AbstractWidget;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;

class TagAutoCompleteWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.tag.widget.autocomplete';
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

    /**
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new TagAutoCompleteWidgetSettings();
    }

    public function getForm()
    {
        return 'tag_widget_autocomplete';
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
     * @param FieldInterface $field
     *
     * @return string
     */
    public function supportsField(FieldInterface $field)
    {
        return ($field->getName() === 'tag');
    }

}
