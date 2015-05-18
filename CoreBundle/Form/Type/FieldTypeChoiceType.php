<?php

namespace Gravity\CoreBundle\Form\Type;

use Gravity\Component\Field\FieldManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldTypeChoiceType
 *
 * @package Gravity\CoreBundle\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTypeChoiceType extends AbstractType
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @param FieldManager $fieldManager
     */
    function __construct(FieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $fields = [];
        foreach($this->fieldManager->getFields() as $field){
            $fields[$field->getName()] = $field->getLabel();
        }

        $resolver->setDefaults([
            'choices' => $fields
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_field_type';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }
}
