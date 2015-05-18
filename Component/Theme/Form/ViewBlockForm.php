<?php

namespace Gravity\Component\Theme\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ViewBlockForm
 *
 * @package Gravity\Component\Theme\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ViewBlockForm extends AbstractType
{
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'gravity_cms_view_block';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'textarea')
            ->add('view', 'entity');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_type' => '\Gravity\Component\Entity\Entity\View'
        ));
    }


}
