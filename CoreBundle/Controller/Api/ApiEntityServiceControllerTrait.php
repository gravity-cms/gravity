<?php

namespace Gravity\CoreBundle\Controller\Api;

use Doctrine\ORM\Query;
use FOS\RestBundle\View\View;
use Gravity\CoreBundle\Entity\Service\EntityServiceInterface;
use Gravity\CoreBundle\FosRest\View\View\JsonApiView;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @TODO    : Permissioning
 *
 * This Trait provices API methods for persisting, fetching and removing entities
 *
 * Class AbstractApiController
 *
 * @package Gravity\Component\Controller
 */
trait ApiEntityServiceControllerTrait
{
    /**
     * Authenticate a user has permission for this method. Throws an AccessDeniedException exception if authentication
     * fails
     *
     * @param string $method One of the Request::METHOD_* constants
     */
    protected function authenticate($method)
    {
        if (!$this->hasPermission($method)) {
            throw new AccessDeniedException();
        }
    }

    /**
     * Verify a user has permission for this method
     *
     * @param string $method One of the Request::METHOD_* constants
     *
     * @return bool
     */
    abstract function hasPermission($method);

    /**
     * [GET] Get all entities
     *
     * @param array $entities
     *
     * @return Response
     */
    protected function cgetEntity(array $entities)
    {
        $this->authenticate(Request::METHOD_GET);

        $view = JsonApiView::create($entities);
        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * [GET] Get a specific entity
     *
     * @param object $entity
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    protected function getEntity($entity)
    {
        $this->authenticate(Request::METHOD_GET);

        $view = JsonApiView::create($entity);
        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Helper to generate a json response
     *
     * @param null  $data
     * @param null  $code
     * @param array $headers
     *
     * @return Response
     */
    protected function jsonResponse($data = null, $code = null, $headers = [])
    {
        $view = View::create($data, $code, $headers);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * [POST] Save a form
     *
     * @param string                 $method        One of the Request::METHOD_* constants
     * @param EntityServiceInterface $entityService The entity service to use
     * @param Form                   $form          Service or class of the form type
     * @param array                  $payload       The payload to submit
     *
     * @return Response
     */
    private function handleEntity($method, EntityServiceInterface $entityService, Form $form, array $payload)
    {
        $this->authenticate($method);

        $form->submit($payload);

        if ($form->isValid()) {
            $entity = $form->getData();

            $entityService->persist($entity);

            return $entity;
        }

        return false;
    }

    /**
     * [POST] Save a form
     *
     * @param EntityServiceInterface $entityService
     * @param Form                   $form
     * @param array                  $payload
     *
     * @return Response
     */
    protected function postEntity(EntityServiceInterface $entityService, Form $form, array $payload)
    {
        return $this->handleEntity(Request::METHOD_POST, $entityService, $form, $payload);
    }

    /**
     * [PUT] Save a form
     *
     * @param EntityServiceInterface $entityService
     * @param Form                   $form
     * @param array                  $payload
     *
     * @return Response
     */
    protected function putEntity(EntityServiceInterface $entityService, Form $form, array $payload)
    {
        return $this->handleEntity(Request::METHOD_PUT, $entityService, $form, $payload);
    }

    /**
     * [PATCH] Save a form
     *
     * @param EntityServiceInterface $entityService
     * @param Form                   $form
     * @param array                  $payload
     *
     * @return Response
     */
    protected function patchEntity(EntityServiceInterface $entityService, Form $form, array $payload)
    {
        return $this->handleEntity(Request::METHOD_PATCH, $entityService, $form, $payload);
    }

    /**
     * [DELETE] Delete an entity
     *
     * @param EntityServiceInterface $entityService
     * @param object                 $entity
     *
     * @return Response
     */
    protected function deleteEntity(EntityServiceInterface $entityService, $entity)
    {
        $this->authenticate(Request::METHOD_DELETE);

        $entityService->remove($entity);

        return true;
    }

    /**
     * @param string                 $method        One of the Request::METHOD_* constants
     * @param EntityServiceInterface $entityService The entity service to use
     * @param object                 $baseEntity    Entity to attach the config to
     * @param Form                   $form          Service or class of the form type
     * @param array                  $payload       The payload to submit
     *
     * @return Response
     */
    private function handleConfig(
        $method,
        EntityServiceInterface $entityService,
        $baseEntity,
        Form $form,
        array $payload
    ) {
        $this->authenticate($method);

        $form->submit($payload);

        if ($form->isValid()) {
            $entity = $form->getData();

            $baseEntity->setConfig(clone $entity);
            $entityService->persist($baseEntity);

            return $entity;
        }

        return false;
    }

    /**
     * [POST] Save a form
     *
     * @param EntityServiceInterface $entityService
     * @param object                 $entity
     * @param Form                   $form
     * @param array                  $payload
     *
     * @return Response
     */
    protected function postConfig(EntityServiceInterface $entityService, $entity, Form $form, array $payload)
    {
        return $this->handleConfig(Request::METHOD_POST, $entityService, $entity, $form, $payload);
    }

    /**
     * [PUT] Save a form
     *
     * @param EntityServiceInterface $entityService
     * @param object                 $entity
     * @param Form                   $form
     * @param array                  $payload
     *
     * @return Response
     */
    protected function putConfig(EntityServiceInterface $entityService, $entity, Form $form, array $payload)
    {
        return $this->handleConfig(Request::METHOD_PUT, $entityService, $entity, $form, $payload);
    }

    /**
     * [PATCH] Save a form
     *
     * @param EntityServiceInterface $entityService
     * @param object                 $entity
     * @param Form                   $form
     * @param array                  $payload
     *
     * @return Response
     */
    protected function patchConfig(EntityServiceInterface $entityService, $entity, Form $form, array $payload)
    {
        return $this->handleConfig(Request::METHOD_PATCH, $entityService, $entity, $form, $payload);
    }
}
