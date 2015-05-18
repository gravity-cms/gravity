<?php

namespace Gravity\CoreBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gravity\Component\Configuration\ConfigurationInterface;
use Gravity\CoreBundle\Controller\Api\Event\ApiConfigurationEvent;
use Gravity\CoreBundle\Controller\Api\Event\ApiEvents;
use Gravity\CoreBundle\FosRest\View\View\JsonApiView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class AbstractApiConfigurationController
 *
 * @package Gravity\CoreBundle\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @deprecated Use ApiEntityServiceControllerTrait instead
 */
abstract class AbstractApiConfigurationController extends Controller implements ClassResourceInterface, ApiControllerInterface
{
    /**
     * Get the default configuration
     *
     * @return ConfigurationInterface
     */
    abstract public function getConfiguration();

    /**
     * Get the form type
     *
     * @return AbstractType
     */
    function getForm()
    {
        return $this->getConfiguration()->getForm();
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
        // TODO
        $configurationManager = $this->get('gravity_cms.config_manager');
        //$configurationManager->getSet()

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

        try
        {
            $configurationManager = $this->get('gravity_cms.config_manager');
            $config = $configurationManager->get($id);

            $view = JsonApiView::create($config);

            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        }
        catch(NoResultException $e)
        {
            throw $this->createNotFoundException('Entity Not Found', $e);
        }
    }

    /**
     * [GET] Get a form for a new entity
     *
     * @return Response
     */
    public function newAction()
    {
        $this->authenticate(self::METHOD_NEW);

        $defaultConfiguration = $this->getConfiguration();

        $form   = $this->createForm($defaultConfiguration->getForm(), $defaultConfiguration, array(
            'method' => 'POST',
            'action' => $this->getUrl(self::METHOD_POST),
        ));

        $html = $this->render($this->getFormTemplate(self::METHOD_NEW), array(
            'form' => $form->createView()
        ));

        $rView = JsonApiView::create(array(
            'form' => $html,
        ));

        return $this->get('fos_rest.view_handler')->handle($rView);
    }

    /**
     * [GET] Get a form for an existing entity
     *
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function editAction($id)
    {
        $this->authenticate(self::METHOD_EDIT);

        try
        {
            $configurationManager = $this->get('gravity_cms.config_manager');
            $config = $configurationManager->get($id);
        }
        catch(NoResultException $e)
        {
            throw $this->createNotFoundException('Entity Not Found', $e);
        }

        $form = $this->createForm($config->getForm(), $config, array(
            'action' => $this->getUrl(self::METHOD_PUT, $config),
            'method' => 'PUT',
        ));

        $html = $this->render($this->getFormTemplate(self::METHOD_EDIT), array(
            'form' => $form->createView()
        ));

        $rView = JsonApiView::create(array(
            'form' => $html,
        ));

        return $this->get('fos_rest.view_handler')->handle($rView);
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
        $configurationManager = $this->get('gravity_cms.config_manager');
        $this->authenticate(self::METHOD_POST);

        $newEntity = $this->getConfiguration();

        $payload = json_decode($request->getContent(), true);

        $formType  = $this->getForm();
        $form      = $this->createForm($formType, $newEntity);
        $form->submit($payload[$formType->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();
            $eventDispatcher = $this->get('event_dispatcher');

            $eventDispatcher->dispatch(ApiEvents::PRE_CREATE, new ApiConfigurationEvent($entity));

            $configurationManager->create($entity);

            $eventDispatcher->dispatch(ApiEvents::POST_CREATE, new ApiConfigurationEvent($entity));

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

        $configurationManager = $this->get('gravity_cms.config_manager');
        $config = $configurationManager->get($id);

        if(!$config instanceof ConfigurationInterface)
        {
            throw $this->createNotFoundException('Config Not Found');
        }

        $payload = json_decode($request->getContent(), true);

        $formType = $config->getForm();
        $form     = $this->createForm($formType, $config);

        $form->submit($payload[$formType->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();

            $eventDispatcher = $this->get('event_dispatcher');
            $eventDispatcher->dispatch(ApiEvents::PRE_UPDATE, new ApiConfigurationEvent($entity));

            $configurationManager->set($entity);

            $eventDispatcher->dispatch(ApiEvents::POST_UPDATE, new ApiConfigurationEvent($entity));

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

    protected function preNew()
    {
    }

    protected function postNew()
    {
    }

    protected function preEdit()
    {
    }

    protected function postEdit()
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
