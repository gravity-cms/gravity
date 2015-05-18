<?php
/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */

namespace Gravity\NodeBundle\Form;


use Gravity\Component\Field\FieldManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentTypeFieldViewChangeForm extends AbstractType
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    function __construct(FieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'field'
        ));
        $resolver->setAllowedTypes(array(
            'field' => '\Gravity\CoreBundle\Entity\Field'
        ));
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field = $this->fieldManager->getField($options['field']->getFieldType());
        $widgets = $this->fieldManager->getFieldWidgets();

        $supportedWidgets = array();
        foreach($widgets as $widget)
        {
            if($widget->supportsField($field))
            {
                $supportedWidgets[$widget->getName()] = $widget->getLabel();
            }
        }

        $builder->add('type', 'choice', array(
            'choices' => $supportedWidgets,
        ));
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'gravity_node_content_type_field_view_change';
    }

}
