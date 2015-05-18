<?php
namespace Gravity\Component\Form\Type;

use Gravity\Component\Form\DataTransformer\TextListTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class TextListType
 *
 * @package Gravity\Component\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TextListType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new TextListTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'text_list';
    }
}
