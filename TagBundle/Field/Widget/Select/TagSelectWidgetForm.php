<?php

namespace Gravity\TagBundle\Field\Widget\Select;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Gravity\TagBundle\Field\Configuration\FieldTagConfiguration;
use GravityCMS\CoreBundle\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TagSelectWidgetForm
 *
 * @package Gravity\TagBundle\Field\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagSelectWidgetForm extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldTagConfiguration $configuration */
        /** @var Field $field */
        $field     = $options['field'];
        $configuration = $field->getConfig();
        $limit         = $configuration->getLimit();
        $rootTag       = $configuration->getTag();

        $builder
            ->add('tags', 'entity', [
                'class'         => 'Gravity\TagBundle\Entity\Tag',
                'query_builder' => function (EntityRepository $er) use ($rootTag) {
                    return $er->createQueryBuilder('u')
                        ->where('u.parentTag = :tag')
                        ->orderBy('u.name', 'ASC')
                        ->setParameter('tag', $rootTag);
                },
                'multiple'      => $configuration->isMultiple(),
                'property'      => 'name',
                'empty_value'   => '',
                'empty_data'    => null,
                'required'      => true,
                'label'         => null
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\TagBundle\Entity\FieldTag'
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
        return 'tag_widget_select';
    }
}
