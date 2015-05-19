<?php

namespace Gravity\CoreBundle\Form\Type;

use Gravity\Component\Field\Validator\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class FieldWidgetType
 *
 * @package Gravity\CoreBundle\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldWidgetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['field']);
        $resolver->setAllowedTypes(
            [
                'field' => 'Gravity\Component\Field\Field',
            ]
        );

        $resolver->setDefaults(
            [
                'constraints' => function (Options $options) {

                    /** @var \Gravity\Component\Field\Field $field */
                    $field       = $options['field'];
                    $constraints = [
                        new Field(
                            [
                                'fields' => $options['field']->getConstraints(),
                            ]
                        )
                    ];

                    if ($field->getSettings()['required']) {
                        $constraints[] = new NotNull();
                    }

                    return $constraints;
                }
            ]
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'field_widget';
    }
}
