<?php

namespace Gravity\NodeBundle\Field\Text;

use Gravity\NodeBundle\Field\Text\Widget\Formatted\FormattedWidget;
use GravityCMS\Component\Field\AbstractField;
use GravityCMS\Component\Field\Display\DisplayInterface;
use GravityCMS\Component\Field\Widget\WidgetInterface;
use Gravity\NodeBundle\Field\Text\Configuration\TextFieldConfiguration;
use Gravity\NodeBundle\Field\Text\Display\TextFieldDisplay;

class TextField extends AbstractField
{
    protected $widget;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Text';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSettings()
    {
        return new TextFieldConfiguration();
    }

    /**
     * @return WidgetInterface
     */
    public function getDefaultWidget()
    {
        return new FormattedWidget();
    }

    /**
     * @return DisplayInterface
     */
    public function getDefaultDisplay()
    {
        return new TextFieldDisplay();
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Gravity\NodeBundle\Entity\FieldText';
    }
}
