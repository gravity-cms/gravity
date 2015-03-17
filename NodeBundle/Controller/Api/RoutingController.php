<?php

namespace Gravity\NodeBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use GravityCMS\CoreBundle\Entity\Route;
use Gravity\NodeBundle\Form\RoutingConfigurationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RoutingController
 *
 * @package Gravity\NodeBundle\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @FOSRest\RouteResource("Routing")
 */
class RoutingController extends Controller implements ClassResourceInterface
{
    /**
     * @return Form
     */
    function getForm()
    {
        return new RoutingConfigurationForm();
    }

    public function putAction(Request $request)
    {
        /** @var EntityManager $em */
        $configManager = $this->get('gravity_cms.configuration_manager');

        $fieldConfigName = 'content_type.routing';
        $fieldConfig     = $configManager->get($fieldConfigName);
        $fieldConfigForm = $fieldConfig->getForm();

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $fieldConfig, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_routing'),
        ));

        $form->submit($payload[$fieldConfigForm->getName()]);

        if ($form->isValid()) {
            $entity = $form->getData();
            $configManager->set($fieldConfigName, $entity);

            $view = View::create(array(
                'location' => $this->generateUrl('gravity_admin_routing_settings'),
            ), 200);
        } else {
            $view = View::create($form);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function getTableAction(Request $request)
    {
        /** @var EntityManager $em */
        $em   = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('GravityCMSCoreBundle:Route');
        $queryBuilder = $repo->createQueryBuilder('r');

        $dataColumns = array(
            'path',
        );

        $draw    = $request->query->get('draw', 1);
        $start   = $request->query->get('start', 0);
        $length  = $request->query->get('length', 25);
        $search  = $request->query->get('search', array());
        $orders   = $request->query->get('order', array());
        $columns = $request->query->get('columns', array());

        $search += array(
            'value' => false,
            'regex' => false,
        );

        if($search['value']){
            foreach($dataColumns as $dataColumn) {
                if ($dataColumn) {
                    $key = ':value_'.$dataColumn;
                    $queryBuilder->orWhere('r.'.$dataColumn.' LIKE '.$key)->setParameter($key, "%{$search['value']}%");
                }
            }
        }

        foreach($orders as $order){
            $order += array(
                'column' => null,
                'dir' => 'asc'
            );
            $queryBuilder->addOrderBy('r.'.$dataColumns[$order['column']], $order['dir'] == 'asc' ? 'asc' : 'desc');
        }

        $totalRecords = $em->createQuery('
            SELECT count(r)
            FROM GravityCMSCoreBundle:Route r
        ')->getSingleScalarResult();

        /** @var Route[] $routes */
        $routes = $queryBuilder->setFirstResult($start)->setMaxResults($length)->getQuery()->getResult();
        $data   = array();

        foreach ($routes as $route) {
            foreach($dataColumns as $i => $dataColumn) {
                if($dataColumn){
                    $row[$i] = $route->{"get".$dataColumn}();
                }
            }
            $data[] = $row;
        }

        return new JsonResponse(array(
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ));
    }
} 
