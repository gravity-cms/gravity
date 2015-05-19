<?php

namespace Gravity\CoreBundle\Form\Type;

use Gravity\Component\Configuration\ConfigurationManager;
use Gravity\Component\Field\Field;
use Gravity\Component\Field\FieldDefinitionInterface;
use Gravity\Component\Field\FieldManager;
use Gravity\CoreBundle\Entity\FieldData;
use Gravity\CoreBundle\Form\DataTransformer\FieldCollectionDataTransformer;
use Gravity\NodeBundle\Entity\Node;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Collection;

class FieldCollectionType extends AbstractType
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @var ConfigurationManager
     */
    protected $configManager;

    /**
     * @var string[]
     */
    protected $fieldLabels;

    /**
     * @param FieldManager         $fieldManager
     * @param ConfigurationManager $configManager
     */
    function __construct(FieldManager $fieldManager, ConfigurationManager $configManager)
    {
        $this->fieldManager  = $fieldManager;
        $this->configManager = $configManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $i = 0;
        if ($options['node'] instanceof Node) {
            $node     = $options['node'];
            $contents = $node->getFields();
            /** @var Field[] $fieldReferences */
            $fieldReferences = $options['fields'];
            $fieldContents   = [];

            /** @var FieldData $content */
            foreach ($contents as $content) {
                $fieldContents[$content->getField()][] = $content;
            }

            foreach ($fieldReferences as $fieldReference) {

                $field                = $fieldReference->getDefinition();
                $fieldWidgetReference = $fieldReference->getWidget();

                if ($field instanceof FieldDefinitionInterface) {
                    $dataClass = $field->getEntityClass();
                    $formClass = $fieldWidgetReference->getDefinition()->getForm();

                    $fieldFormSettings = $fieldReference->getSettings();

                    /** @var FieldData $entity */
                    if (array_key_exists($fieldReference->getName(), $fieldContents)) {
                        $entities = $fieldContents[$fieldReference->getName()];
                    } else {
                        $entity = new $dataClass();
                        // TODO: set the default value in the widget
                        $entities = [$entity];
                    }

                    $this->fieldLabels[$i] = $fieldReference;
                    $builder->add(
                        $i,
                        'field_data_collection',
                        [
                            'type'         => $formClass,
                            'options'      => [
                                'label' => false,
                                'field' => $fieldReference,
                            ],
                            'required'     => $fieldFormSettings['required'],
                            'field'        => $fieldReference,
                            'limit'        => (int)$fieldFormSettings['limit'] ?: 1,
                            'label'        => false,
                            'allow_add'    => true,
                            'allow_delete' => true,
                            'data'         => $entities,
                            'by_reference' => false,
                        ]
                    );
                    ++$i;
                }
            }
        }
        $builder->addModelTransformer(new FieldCollectionDataTransformer());
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(
            [
                'node',
                'fields'
            ]
        );
        $resolver->setAllowedTypes(
            [
                'fields' => 'array'
            ]
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['field_labels'] = $this->fieldLabels;
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'field_collection';
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return 'form';
    }


} 
