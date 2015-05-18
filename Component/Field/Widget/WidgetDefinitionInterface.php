<?php

namespace Gravity\Component\Field\Widget;

use Gravity\Component\Asset\AssetLibraryInterface;
use Gravity\Component\Field\FieldDefinitionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface WidgetDefinitionInterface
 *
 * @package Gravity\Component\Field\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface WidgetDefinitionInterface
{
    /**
     * Get the identifier name of the field widget. This must be a unique name and contain only alphanumeric,
     * underscores (_) and period (.) characters in the format field.widget.<plugin>.<type>
     *
     * @return string
     */
    public function getName();

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get the description of the field widget
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the form type for this widget
     *
     * @return AbstractType
     */
    public function getForm();

    /**
     * Get a list of asset libraries to use
     *
     * @return AssetLibraryInterface[]
     */
    public function getAssetLibraries();

    /**
     * Checks if this widget supports the given field
     *
     * @param FieldDefinitionInterface $field
     *
     * @return string
     */
    public function supportsField(FieldDefinitionInterface $field);

    /**
     * @param OptionsResolver $optionsResolver
     *
     * @return void
     */
    public function setOptions(OptionsResolver $optionsResolver);
}
