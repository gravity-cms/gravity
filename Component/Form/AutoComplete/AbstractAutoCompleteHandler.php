<?php

namespace Gravity\Component\Form\AutoComplete;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Gravity\Component\Form\AutoComplete\Exception\AutoCompleteHandlerException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractAutoCompleteHandler
 *
 * @package Gravity\Component\Form\AutoComplete
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractAutoCompleteHandler implements AutoCompleteHandlerInterface
{
    const SEARCH_TYPE_CONTAINS    = 'contains';
    const SEARCH_TYPE_STARTS_WITH = 'starts_with';
    const SEARCH_TYPE_ENDS_WITH   = 'ends_with';

    /**
     * @var string
     */
    protected $dataClass;

    /**
     * @var string
     */
    protected $dataProperty;

    /**
     * @var string
     */
    protected $searchType = self::SEARCH_TYPE_CONTAINS;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * {@inheritdoc}
     */
    public function getDataClass()
    {
        return $this->dataClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataProperty()
    {
        return $this->dataProperty;
    }

    public function getOptions($term, array $options = array())
    {
        $repo = $this->entityManager->getRepository($this->dataClass);

        $alias     = 't';
        $condition = $this->buildSearchCondition($term);

        $results = $repo->createQueryBuilder($alias)
            ->select($alias . '.' . $this->dataProperty)
            ->where($alias . '.' . $this->dataProperty . ' LIKE :cond')
            ->setParameter('cond', $condition)
            ->getQuery()->getArrayResult();

        $prop = $this->dataProperty;
        $options = array_map(function($a) use ($prop){
            return array(
                'id'   => $a[$prop],
                'text' => $a[$prop],
            );
        }, $results);

        return $options;
    }

    /**
     * @param array $ids
     *
     * @param array $options
     *
     * @return \object[]
     */
    public function getObjects(array $ids = array(), array $options = array())
    {
        $objects = new ArrayCollection();
        foreach ($ids as $id) {
            $tag = $this->entityManager->getRepository($this->dataClass)->findOneBy(array($this->dataProperty => $id));
            if ($tag instanceof $this->dataClass) {
                $objects[] = $tag;
            }
        }

        return $objects;
    }

    /**
     * Fetch an array of options to pass into the query url
     *
     * @return array
     */
    public function getUrlOptions()
    {
        return null;
    }

    /**
     * Build a search statement for a alias and field
     *
     * @param $term
     *
     * @return string
     * @throws AutoCompleteHandlerException
     */
    protected function buildSearchCondition($term)
    {
        switch ($this->searchType) {
            case self::SEARCH_TYPE_CONTAINS:
                $condition = '%' . $term . '%';
                break;
            case self::SEARCH_TYPE_STARTS_WITH:
                $condition = $term . '%';
                break;
            case self::SEARCH_TYPE_ENDS_WITH:
                $condition = '%' . $term;
                break;
            default:
                throw new AutoCompleteHandlerException("Search type does not exist");
                break;
        }

        return $condition;
    }
}
