<?php

namespace Gravity\TagBundle\AutoComplete;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Gravity\TagBundle\Entity\Tag;
use Gravity\TagBundle\Field\Configuration\FieldTagConfiguration;
use GravityCMS\Component\Field\FieldManager;
use GravityCMS\Component\Form\AutoComplete\AbstractAutoCompleteHandler;

class TagAutoCompleteHandler extends AbstractAutoCompleteHandler
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    public function __construct(FieldManager $fieldManager, EntityManager $entityManager)
    {
        $this->fieldManager  = $fieldManager;
        $this->entityManager = $entityManager;
        $this->dataClass     = '\Gravity\TagBundle\Entity\Tag';
        $this->dataProperty  = 'name';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions($term, array $options = [])
    {
        $options += [
            'field' => null,
        ];

        if (!isset($options['field'])) {
            return [];
        }

        $field = $this->fieldManager->getField('tag', $options['field']);
        $fieldConfig = $field->getSettings();

        $repo = $this->entityManager->getRepository($this->dataClass);

        $condition = $this->buildSearchCondition($term);

        $query = $repo->createQueryBuilder('t')
            ->select('t.' . $this->dataProperty)
            ->andWhere('t.' . $this->dataProperty . ' LIKE :cond')
            ->andWhere('t.parentTag = :parent')
            ->setParameters([
                'cond'   => $condition,
                'parent' => $fieldConfig['tag'],
            ])
            ->getQuery();

        $results = $query->getArrayResult();

        $prop          = $this->dataProperty;
        $matchTerm     = strtolower($term);
        $hasExactMatch = false;
        $options       = array_map(function ($a) use ($prop, $matchTerm, &$hasExactMatch) {
            if (strtolower($a[$prop]) === $matchTerm) {
                $hasExactMatch = true;
            }

            return [
                'id'   => $a[$prop],
                'text' => $a[$prop],
            ];
        }, $results);

        if (!$hasExactMatch && $fieldConfig['allow_new']) {
            $cleanTerm = htmlspecialchars($term);
            $options[] = [
                'id'   => $cleanTerm,
                'text' => $cleanTerm,
            ];
        }

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjects(array $ids = [], array $options = [])
    {
        $options += [
            'field' => null,
        ];
        $objects = new ArrayCollection();

        if (!isset($options['field'])) {
            return $objects;
        }

        $field = $this->fieldManager->getField('tag', $options['field']);
        $fieldConfig = $field->getSettings();

        $parentTag = $tag = $this->entityManager->getRepository($this->dataClass)->find($fieldConfig['tag']);

        foreach ($ids as $id) {
            $tag = $this->entityManager->getRepository($this->dataClass)->findOneBy([
                $this->dataProperty => $id,
                'parentTag'         => $fieldConfig['tag'],
            ]);
            if ($tag instanceof $this->dataClass) {
                $objects[] = $tag;
            } elseif($fieldConfig['allow_new']) {
                $tag = new Tag();
                $tag->setName($id);
                $tag->setParentTag($parentTag);
                $objects[] = $tag;
            }
        }

        return $objects;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_tag';
    }
}
