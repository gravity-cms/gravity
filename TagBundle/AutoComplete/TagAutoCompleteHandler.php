<?php

namespace Gravity\TagBundle\AutoComplete;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use GravityCMS\Component\Form\AutoComplete\AbstractAutoCompleteHandler;

class TagAutoCompleteHandler extends AbstractAutoCompleteHandler
{
    public function __construct(EntityManager $entityManager)
    {
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
            'parent' => null,
        ];

        $repo = $this->entityManager->getRepository($this->dataClass);

        $alias     = 't';
        $condition = $this->buildSearchCondition($term);

        $query = $repo->createQueryBuilder($alias)
            ->select($alias . '.' . $this->dataProperty)
            ->andwhere($alias . '.' . $this->dataProperty . ' LIKE :cond')
            ->andWhere($alias . '.parentTag = :parent')
            ->setParameters([
                'cond'   => $condition,
                'parent' => $options['parent']
            ])
            ->getQuery();

        $results = $query->getArrayResult();

        $prop = $this->dataProperty;
        $options = array_map(function($a) use ($prop){
            return [
                'id'   => $a[$prop],
                'text' => $a[$prop],
            ];
        }, $results);

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjects(array $ids = [], array $options = [])
    {
        $options += [
            'parent' => null,
        ];

        $objects = new ArrayCollection();
        foreach ($ids as $id) {
            $tag = $this->entityManager->getRepository($this->dataClass)->findOneBy([
                $this->dataProperty => $id,
                'parentTag' => $options['parent'],
            ]);
            if ($tag instanceof $this->dataClass) {
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
