<?php
/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */

namespace Gravity\Component\Form\Type;

use Gravity\Component\Form\DataTransformer\BasicRouteTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class BasicRouteType
 *
 * @package Gravity\Component\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class BasicRouteType extends AbstractType
{
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'basic_route';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('path', 'text');

        $builder->addModelTransformer(new BasicRouteTransformer($options['data_class']));
    }
}
