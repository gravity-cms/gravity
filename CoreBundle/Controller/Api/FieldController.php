<?php

namespace Gravity\CoreBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gravity\Component\Configuration\ConfigurationInterface;
use Gravity\CoreBundle\Entity\Field;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContentTypeController
 *
 * @package Gravity\NodeBundle\Controller\Api
 *
 * @FOSRest\RouteResource("Field")
 */
class FieldController extends Controller implements ClassResourceInterface
{
    use ApiEntityServiceControllerTrait;

    /**
     * [GET] A collection of entities
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgetAction()
    {
        $service  = $this->get('gravity.entity_service.field');
        $entities = $service->getEntityRepository()->findAll();

        return $this->cgetEntity($entities);
    }

    /**
     * [GET] A single entity
     *
     * @param Field $field
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Field $field)
    {
        return $this->getEntity($field);
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
        $service = $this->get('gravity.entity_service.field');
        $form    = $this->createForm(
            'gravity_field',
            $service->create(),
            [
                'method' => 'POST',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->postEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof Field) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            201,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_field',
                    [
                        'field' => $entity->getId()
                    ]
                )
            ]
        );
    }

    /**
     * [PUT] Update an existing entity
     *
     * @param Request $request
     * @param Field   $field
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Request $request, Field $field)
    {
        $service = $this->get('gravity.entity_service.field');
        $form    = $this->createForm(
            'gravity_field',
            $field,
            [
                'method' => 'PUT',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->putEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof Field) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            204,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_field',
                    [
                        'field' => $entity->getId()
                    ]
                )
            ]
        );
    }

    /**
     * [PATCH] Partial update an existing entity
     *
     * @param Request $request
     * @param Field   $field
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function patchAction(Request $request, Field $field)
    {
        $service = $this->get('gravity.entity_service.field');
        $form    = $this->createForm(
            'gravity_field',
            $field,
            [
                'method' => 'PATCH',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->patchEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof Field) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            204,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_field',
                    [
                        'field' => $entity->getId()
                    ]
                )
            ]
        );
    }

    /**
     * [DELETE] Delete a Field entity
     *
     * @param Field $field
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Field $field)
    {
        $success = $this->deleteEntity(
            $this->get('gravity.entity_service.field'),
            $field
        );

        if($success){
            $this->getDoctrine()->getManager()->flush();
        }

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
     * [PUT] Update a Field entity's settings
     *
     * @param Request $request
     * @param Field   $field
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSettingsAction(Request $request, Field $field)
    {
        $service = $this->get('gravity.entity_service.field');

        $config  = clone $field->getConfig();
        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm(
            $config->getForm(),
            $config,
            [
                'method' => 'PUT',
            ]
        );

        $config = $this->putConfig($service, $field, $form, $payload[$form->getName()]);

        if (!$config instanceof ConfigurationInterface) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(null, 204);
    }

    /**
     * {@inheritdoc}
     */
    public function hasPermission($method)
    {
        return true;
        //        $userManager = $this->get('nefarian_core.user_manager');
        //        switch ($method) {
        //            case Request::METHOD_NEW:
        //            case Request::METHOD_POST:
        //                return $userManager->hasPermission($this->getUser(), 'content.type.create');
        //                break;
        //
        //            case Request::METHOD_EDIT:
        //            case Request::METHOD_PUT:
        //                return $userManager->hasPermission($this->getUser(), 'content.type.update');
        //                break;
        //
        //            case Request::METHOD_DELETE:
        //                return $userManager->hasPermission($this->getUser(), 'content.type.delete');
        //                break;
        //
        //            case Request::METHOD_GET:
        //                return $userManager->hasPermission($this->getUser(), 'content.type.get');
        //                break;
        //        }
        //
        //        return false;
    }

} 
