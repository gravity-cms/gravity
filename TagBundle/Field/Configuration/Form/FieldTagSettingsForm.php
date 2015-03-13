<?php

namespace Gravity\TagBundle\Field\Configuration\Form;

use Doctrine\ORM\EntityRepository;
use Nefarian\CmsBundle\Configuration\ConfigurationInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldTagSettingsForm
 *
 * @package Gravity\TagBundle\Field\Configuration\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTagSettingsForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tag', 'tag_choice', [
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.parentTag IS NULL')
                        ->orderBy('u.name', 'ASC');
                },
            ])
            ->add('multiple', 'checkbox', [
                'required' => false
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Gravity\TagBundle\Field\Configuration\FieldTagConfiguration',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'gravity_field_tag_configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field_configuration';
    }
}
