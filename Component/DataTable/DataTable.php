<?php

namespace Gravity\Component\DataTable;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Orx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

class DataTable
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(Router $router, EntityManager $entityManager)
    {
        $this->router        = $router;
        $this->entityManager = $entityManager;
    }

    public function create(DataTableTypeInterface $dataTableType, Request $request)
    {
        $view         = new DataTableView();
        $queryBuilder = $dataTableType->buildDataSet($this->entityManager);
        $columns = $request->query->get('columns', array());

        $fields = $dataTableType->getSchema();

        // order
        $orders = $request->query->get('order', array());
        if (is_array($orders) && count($orders)) {
            foreach ($orders as $i => $order) {
                // Convert the column index into the column data property
                $columnIdx     = intval($orders[$i]['column']);
                $requestColumn = $columns[$columnIdx];
                if ($requestColumn['orderable'] == 'true') {
                    $dbColumn = $fields[$columnIdx]['column'];
                    $dir       = $order['dir'] === 'asc' ? 'ASC' : 'DESC';
                    $queryBuilder->addOrderBy($dbColumn, $dir);
                }
            }
        }

        // filter
        $searches = $request->query->get('search', array());
        if(is_array($searches) && count($searches))
        {
            $searchTerm = $searches['value'];
            if($searchTerm) {
                $params = array();
                $or = new Orx();
                foreach ($fields as &$field) {
                    if ($field['searchable'] && $dbColumn = $field['column']) {
                        $termHash = md5($dbColumn);
                        $or->add($dbColumn . " LIKE :term_{$termHash}");
                        $params["term_{$termHash}"] = "%{$searchTerm}%";
                    }
                }
                $queryBuilder->andWhere($or)
                    ->setParameters($params);
            }
        }

        // limit
        $limitStart  = $request->query->get('start', 0);
        $limitLength = $request->query->get('length', -1);
        if ($limitStart && $limitLength != -1) {
            $queryBuilder->setFirstResult($limitStart);
            $queryBuilder->setMaxResults($limitLength);
        }

        $query = $queryBuilder->getQuery();
        $data = $query->getScalarResult();

        $tableData = array();
        foreach($data as $dataRow)
        {
            $row = array();
            foreach($fields as $field)
            {
                if(isset($field['column']) && $column = $field['column']) {
                    $scalarColumn = str_replace('.', '_', $column);
                    if (isset($dataRow[$scalarColumn])) {
                        $row[] = $dataRow[$scalarColumn];
                    } else {
                        $row[] = '';
                    }
                } elseif(isset($field['html'])) {
                    if(is_callable($field['html']))
                    {
                        $row[] = call_user_func_array($field['html'], array(
                            $dataRow,
                        ));
                    } else {
                        $row[] = $field['html'];
                    }
                } else {
                    $row[] = '&nbsp;';
                }
            }
            $tableData[] = $row;
        }

        return array(
            'draw' => $request->query->get('draw'),
            'data' => $tableData,
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
        );
    }

}
