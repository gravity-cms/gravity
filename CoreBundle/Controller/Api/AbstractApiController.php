<?php

namespace Gravity\CoreBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gravity\CoreBundle\FosRest\View\View\JsonApiView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @TODO    : Permissioning
 *
 * Class AbstractApiController
 *
 * @package Gravity\Component\Controller
 *
 * @deprecated Use ApiEntityServiceControllerTrait instead
 */
abstract class AbstractApiController extends Controller implements ClassResourceInterface, ApiControllerInterface
{
    /**
     * Get the entity name
     *
     * @return string
     */
    abstract protected function getEntityClass();

    /**
     * Configure the query builder
     *
     * @param QueryBuilder $qb
     *
     * @return mixed
     */
    function setupQueryBuilder(QueryBuilder $qb)
    {
    }

    /**
     * Get the template for the form
     *
     * @param $method
     *
     * @return string
     */
    function getFormTemplate($method)
    {
        return '@theme/Api/form.html.twig';
    }

    protected function authenticate($method)
    {
        if(!$this->hasPermission($method))
        {
            throw new AccessDeniedException();
        }
    }

    /**
     * [GET] Get all entities
     *
     * @return Response
     */
    public function cgetAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository($this->getEntityClass())->createQueryBuilder('e');
        $this->setupQueryBuilder($qb);

        $entities = $qb->getQuery()->getArrayResult();

        $view = JsonApiView::create($entities);

        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * [GET] Get a specific entity
     *
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function getAction($id)
    {
        $this->authenticate(self::METHOD_GET);

        /** @var EntityManager $em */
        $class = $this->getEntityClass();
        $em    = $this->getDoctrine()->getManager();

        try
        {
            $qb = $em->getRepository($class)
                ->createQueryBuilder('e');
            $this->setupQueryBuilder($qb);

            $entity = $qb->andWhere('e.id = ?1')->setParameter(1, $id)
                ->getQuery()->getSingleResult(Query::HYDRATE_ARRAY);

            $view = JsonApiView::create($entity);

            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        }
        catch(NoResultException $e)
        {
            throw $this->createNotFoundException('Entity Not Found', $e);
        }
    }

    /**
     * [POST] Save a form
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        $this->authenticate(self::METHOD_POST);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $payload = json_decode($request->getContent(), true);

        $class     = $this->getEntityClass();
        $newEntity = new $class();
        $form      = $this->createForm($this->getForm(), $newEntity);
        $form->submit($payload[$form->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();

            $this->preCreate($entity);

            $em->persist($entity);
            $em->flush();

            $this->postCreate($entity);

            $view = JsonApiView::create(null, 201, array(
                'location' => $this->getUrl(self::METHOD_VIEW_ALL, $entity)
            ));
        }
        else
        {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * [PUT] Save a form
     *
     * @param Request $request
     * @param int     $id
     *
     * @throws NotFoundHttpException
     * @return Response
     */
    public function putAction(Request $request, $id)
    {
        $this->authenticate(self::METHOD_PUT);

        /** @var EntityManager $em */
        $class  = $this->getEntityClass();
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository($class)->find($id);

        if(!$entity instanceof $class)
        {
            throw $this->createNotFoundException('Entity Not Found');
        }

        $payload = json_decode($request->getContent(), true);

        $formType = $this->getForm();
        $form     = $this->createForm($formType, $entity);

        $form->submit($payload[$formType->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();

            $this->preUpdate($entity);

            $em->persist($entity);
            $em->flush();

            $this->postUpdate($entity);

            $view = JsonApiView::create(null, 200, array(
                'location' => $this->getUrl(self::METHOD_GET, $entity)
            ));
        }
        else
        {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * [DELETE] Delete a node
     *
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function deleteAction($id)
    {
        $this->authenticate(self::METHOD_DELETE);

        /** @var EntityManager $em */
        $class  = $this->getEntityClass();
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository($class)->find($id);

        if(!$entity instanceof $class)
        {
            throw $this->createNotFoundException('Entity Not Found');
        }

        $this->preDelete($entity);

        $em->remove($entity);
        $em->flush();

        $this->postDelete();

        $view = new JsonApiView(array(
            'location' => $this->getUrl(self::METHOD_VIEW_ALL)
        ), 204);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    protected function preGet()
    {
    }

    protected function postGet()
    {
    }

    protected function preCreate($entity)
    {
    }

    protected function postCreate($entity)
    {
    }

    protected function preUpdate($entity)
    {
    }

    protected function postUpdate($entity)
    {
    }

    protected function preDelete($entity)
    {
    }

    protected function postDelete()
    {
    }
}
