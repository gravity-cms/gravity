<?php


namespace Gravity\CoreBundle\Field\Number\Display\Number\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class NumberDisplayConfigurationForm
 *
 * @package Gravity\CoreBundle\Field\Number\Display\Number\Configuration
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class NumberDisplayConfigurationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_type_text_display_html_settings';
    }

}
