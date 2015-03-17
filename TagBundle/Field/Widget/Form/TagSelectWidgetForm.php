<?php

namespace Gravity\TagBundle\Field\Widget\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Gravity\TagBundle\Field\Configuration\FieldTagConfiguration;
use Gravity\NodeBundle\Entity\ContentTypeField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldTagConfiguration $configuration */
        /** @var ContentTypeField $typeField */
        $typeField     = $options['content_type_field'];
        $configuration = $typeField->getConfig();
        $limit         = $configuration->getLimit();
        $rootTag       = $configuration->getTag();

        $builder
            ->add('tags', 'collection', [
                'type'    => 'entity',
                'options' => [
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
                    'label'         => false,
                ],
            ]);
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Gravity\TagBundle\Entity\FieldTag'
            ]
        );

        $resolver->setRequired(['content_type_field']);
        $resolver->setAllowedTypes([
            'content_type_field' => '\Gravity\NodeBundle\Entity\ContentTypeField',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tag_widget_select';
    }
}
