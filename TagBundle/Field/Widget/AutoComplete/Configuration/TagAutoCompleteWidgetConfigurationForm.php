<?php

namespace Gravity\TagBundle\Field\Widget\AutoComplete\Configuration;

use Doctrine\ORM\EntityRepository;
use Gravity\TagBundle\Field\Configuration\FieldTagConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TagAutoCompleteWidgetConfigurationForm
 *
 * @package Gravity\TagBundle\Field\Widget\AutoComplete\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagAutoCompleteWidgetConfigurationForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldTagConfiguration $fieldConfig */
        $fieldConfig = $options['field_config'];

        $builder
            ->add('default', 'tag_choice', [
                'query_builder' => function (EntityRepository $er) use ($fieldConfig) {
                    return $er->createQueryBuilder('u')
                        ->where('u.parentTag = :parentTag')
                        ->setParameter('parentTag', $fieldConfig->getTag())
                        ->orderBy('u.name', 'ASC');
                },
                'multiple' => $fieldConfig->isMultiple(),
            ]);
    }


    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_type' => 'Gravity\TagBundle\Entity\FieldTag'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_tag_widget_autocomplete_configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'field_widget_configuration';
    }
}
