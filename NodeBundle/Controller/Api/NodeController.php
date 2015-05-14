<?php

namespace Gravity\NodeBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gravity\NodeBundle\Entity\Node;
use GravityCMS\CoreBundle\Controller\Api\ApiEntityServiceControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NodeController
 *
 * @package Gravity\NodeBundle\Controller\Api
 *
 * @FOSRest\RouteResource("Node")
 */
class NodeController extends Controller implements ClassResourceInterface
{
    use ApiEntityServiceControllerTrait;

    /**
     * [GET] A collection of entities
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgetAction()
    {
        $service  = $this->get('gravity.entity_service.node');
        $entities = $service->getEntityRepository()->findAll();

        return $this->cgetEntity($entities);
    }

    /**
     * [GET] A single entity
     *
     * @param Node $node
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Node $node)
    {
        return $this->getEntity($node);
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
        $service = $this->get('gravity.entity_service.node');
        $form    = $this->createForm(
            'gravity_node',
            $service->create(),
            [
                'method' => 'POST',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->postEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof Node) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            201,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_node',
                    [
                        'node' => $entity->getId()
                    ]
                )
            ]
        );
    }

    /**
     * [PUT] Update an existing entity
     *
     * @param Request $request
     * @param Node    $node
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Request $request, Node $node)
    {
        $service = $this->get('gravity.entity_service.node');
        $form    = $this->createForm(
            'gravity_node',
            $node,
            [
                'method' => 'PUT',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->putEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof Node) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            204,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_node',
                    [
                        'node' => $entity->getId()
                    ]
                )
            ]
        );
    }

    /**
     * [PATCH] Partial update an existing entity
     *
     * @param Request $request
     * @param Node    $node
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function patchAction(Request $request, Node $node)
    {
        $service = $this->get('gravity.entity_service.node');
        $form    = $this->createForm(
            'gravity_node',
            $node,
            [
                'method' => 'PATCH',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->patchEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof Node) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            204,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_node',
                    [
                        'node' => $entity->getId()
                    ]
                )
            ]
        );
    }

    /**
     * [DELETE] Delete a Field entity
     *
     * @param Node $node
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Node $node)
    {
        $success = $this->deleteEntity(
            $this->get('gravity.entity_service.node'),
            $node
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


    /**
     * @param Request $request
     * @param string  $contentType
     *
     * @return Response
     */
    public function postTypeAction(Request $request, $contentType)
    {
        $contentType = $this->get('gravity_node.content_type_repository')->get($contentType);

        $service = $this->get('gravity.entity_service.node');
        /** @var Node $node */
        $node = $service->create();
        $node->setContentType($contentType->getId());

        $form    = $this->createForm(
            'gravity_node',
            $node,
            [
                'content_type'    => $contentType,
                'csrf_protection' => false,
                'method'          => 'POST',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->postEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof Node) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            201,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_node',
                    [
                        'node' => $entity->getId()
                    ]
                )
            ]
        );
    }

    function hasPermission($method)
    {
        return true;
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

} 
