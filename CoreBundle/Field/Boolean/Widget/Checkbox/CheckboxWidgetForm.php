<?php


namespace Gravity\CoreBundle\Field\Boolean\Widget\Checkbox;

use Gravity\Component\Field\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CheckboxWidgetForm
 *
 * @package gravity\CoreBundle\Field\Boolean\Widget\Checkbox
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class CheckboxWidgetForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Field $field */
        $field = $options['field'];
        $fieldSettings = $field->getSettings();
        $limit = $fieldSettings['limit'];

        $builder
            ->add('value', 'checkbox', [
                'label' => $limit == 1 ? $fieldSettings['label'] : false,
                'attr'  => [
                    'data-limit' => $limit,
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\CoreBundle\Entity\FieldBoolean',
            ]
        );
    }

    public function getParent()
    {
        return 'field_widget';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gravity_field_boolean_widget_checkbox';
    }
}
