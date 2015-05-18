<?php

namespace Gravity\Component\Theme\View\DataTable;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Gravity\Component\DataTable\DataTableTypeInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ViewDataTableType
 *
 * @package Gravity\Component\Theme\View\DataTable
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ViewDataTableType implements DataTableTypeInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildDataSet(EntityManager $entityManager)
    {
        return $entityManager->getRepository('NefarianCmsBundle:View')
            ->createQueryBuilder('v')
            ->addSelect('r')
            ->innerJoin('v.route', 'r');
    }

    public function buildSearch(QueryBuilder $queryBuilder, $query)
    {
        // TODO: Implement buildSearch() method.
    }

    public function buildPagination(QueryBuilder $queryBuilder, $page)
    {
        // TODO: Implement buildPagination() method.
    }

    public function getSchema()
    {
        $router = $this->router;

        return array(
            array(
                'name'       => 'Name',
                'column'     => 'v.name',
                'searchable' => true,
                'sortable'   => true,
            ),
            array(
                'name'       => 'Path',
                'column'     => 'r.path',
                'searchable' => true,
                'sortable'   => true,
            ),
            array(
                'name'       => 'Actions',
                'html'       => function ($entity) use ($router) {
                    $editUrl = $router->generate('nefarian_view_edit', array(
                        'view' => $entity['v_id'],
                    ));

                    return '<a class="btn btn-primary" href="' . $editUrl . '">Edit</a>';
                },
                'searchable' => false,
                'sortable'   => false,
            )
        );
    }

    public function setOption($option, $value)
    {
        // TODO: Implement setOption() method.
    }

}
