<?php

namespace Gravity\NodeBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use Gravity\NodeBundle\Form\ContentTypeFormViewForm;
use Gravity\NodeBundle\Structure\Model\ContentType;
use Gravity\CoreBundle\Controller\Api\ApiEntityServiceControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContentTypeController
 *
 * @package Gravity\NodeBundle\Controller\Api
 *
 * @FOSRest\RouteResource("Type")
 */
class ContentTypeController extends Controller
{
    use ApiEntityServiceControllerTrait;

    /**
     * [GET] A collection of entities
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgetAction()
    {
        $service  = $this->get('gravity.entity_service.content_type');
        $entities = $service->getEntityRepository()->findAll();

        return $this->cgetEntity($entities);
    }

    /**
     * [GET] A single entity
     *
     * @param ContentType $contentType
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(ContentType $contentType)
    {
        return $this->getEntity($contentType);
    }

    /**
     * [POST] Create a new entity
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request)
    {
        $service = $this->get('gravity.entity_service.content_type');
        $form    = $this->createForm(
            'gravity_node_content_type',
            $service->create(),
            [
                'method' => 'POST',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->postEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof ContentType) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            201,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_type',
                    [
                        'contentType' => $entity->getId()
                    ]
                )
            ]
        );
    }

    /**
     * [PUT] Update an existing entity
     *
     * @param Request     $request
     * @param ContentType $contentType
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Request $request, ContentType $contentType)
    {
        $service = $this->get('gravity.entity_service.content_type');
        $form    = $this->createForm(
            'gravity_node_content_type',
            $contentType,
            [
                'method' => 'PUT',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->putEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof ContentType) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            204,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_type',
                    [
                        'contentType' => $entity->getId()
                    ]
                )
            ]
        );
    }

    /**
     * [PATCH] Partial update an existing entity
     *
     * @param Request     $request
     * @param ContentType $contentType
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function patchAction(Request $request, ContentType $contentType)
    {
        $service = $this->get('gravity.entity_service.content_type');
        $form    = $this->createForm(
            'gravity_node_content_type',
            $contentType,
            [
                'method' => 'PATCH',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->patchEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof ContentType) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            204,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_type',
                    [
                        'contentType' => $entity->getId()
                    ]
                )
            ]
        );
    }

    /**
     * [DELETE] Delete a Field entity
     *
     * @param ContentType $contentType
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(ContentType $contentType)
    {
        $success = $this->deleteEntity(
            $this->get('gravity.entity_service.content_type'),
            $contentType
        );

        if ($success) {
            return $this->jsonResponse(
                null,
                204
            );
        } else {
            return $this->jsonResponse(
                null,
                400
            );
        }

    }

    function hasPermission($method)
    {
        return true;
        //        $this->get('security.acl.provider');
        //        $userManager = $this->get('nefarian_core.user_manager');
        //        switch ($method) {
        //            case self::METHOD_NEW:
        //            case self::METHOD_POST:
        //                return $userManager->hasPermission($this->getUser(), 'content.type.create');
        //                break;
        //
        //            case self::METHOD_EDIT:
        //            case self::METHOD_PUT:
        //                return $userManager->hasPermission($this->getUser(), 'content.type.update');
        //                break;
        //
        //            case self::METHOD_DELETE:
        //                return $userManager->hasPermission($this->getUser(), 'content.type.delete');
        //                break;
        //
        //            case self::METHOD_GET:
        //                return $userManager->hasPermission($this->getUser(), 'content.type.get');
        //                break;
        //        }
        //
        //        return false;
    }

    /**
     * Set the order of the widgets
     *
     * @param Request     $request
     * @param ContentType $contentType
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putWidgetsAction(Request $request, ContentType $contentType)
    {
        $service = $this->get('gravity.entity_service.content_type');
        $form    = $this->createForm(
            new ContentTypeFormViewForm(),
            $contentType,
            [
                'method' => 'PUT',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->putEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof ContentType) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            204,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_type',
                    [
                        'contentType' => $entity->getId()
                    ]
                )
            ]
        );
    }
} 
