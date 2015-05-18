<?php
namespace Gravity\Component\DataTable;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DataTableTypeInterface
 *
 * @package Gravity\Component\DataTable
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface DataTableTypeInterface
{
    /**
     * @param EntityManager $entityManager
     *
     * @return QueryBuilder
     */
    public function buildDataSet(EntityManager $entityManager);

    public function buildSearch(QueryBuilder $queryBuilder, $query);

    public function buildPagination(QueryBuilder $queryBuilder, $page);

    public function getSchema();

    public function setOption($option, $value);
}
