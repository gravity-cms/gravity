<?php


namespace Gravity\CoreBundle\Field\Choice\Widget\Select;

use Gravity\Component\Field\Field;
use Gravity\CoreBundle\Field\Choice\Widget\Select\DataTransformer\ChoiceArrayToStringDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SelectWidgetForm
 *
 * @package Gravity\CoreBundle\Field\Choice\Widget\Select
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SelectWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Field $field */
        $field         = $options['field'];
        $fieldSettings = $field->getSettings();

        // if the field is not multiple, we need to transform the data from an array format to a string format
        if(!$fieldSettings['multiple']){
            $builder->addModelTransformer(new ChoiceArrayToStringDataTransformer());
        }

        $builder
            ->add(
                'values',
                'choice',
                [
                    'empty_data'  => [],
                    'choices'     => $fieldSettings['choices'],
                    'multiple'    => $fieldSettings['multiple'],
                    'required'    => $fieldSettings['required'],
                    'label'       => null
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\CoreBundle\Entity\FieldChoice'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_field_choice_widget_select';
    }
}
