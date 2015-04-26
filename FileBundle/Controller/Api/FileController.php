<?php

namespace Gravity\FileBundle\Controller\Api;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Gravity\FileBundle\Entity\File;
use GravityCMS\CoreBundle\Controller\Api\ApiEntityServiceControllerTrait;
use GravityCMS\CoreBundle\FosRest\View\View\JsonApiView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API for File
 *
 * Class FileController
 *
 * @package Gravity\FileBundle\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileController extends Controller implements ClassResourceInterface
{
    use ApiEntityServiceControllerTrait;

    /**
     * [GET] A collection of entities
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgetAction()
    {
        $service  = $this->get('gravity.entity_service.file');
        $entities = $service->getEntityRepository()->findAll();

        return $this->cgetEntity($entities);
    }

    /**
     * [GET] A single entity
     *
     * @param File $file
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(File $file)
    {
        return $this->getEntity($file);
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
        $service = $this->get('gravity.entity_service.file');
        $form    = $this->createForm(
            'gravity_file',
            $service->create(),
            [
                'method' => 'POST',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->postEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof File) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            201,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_file',
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
     * @param Request $request
     * @param File    $file
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Request $request, File $file)
    {
        $service = $this->get('gravity.entity_service.file');
        $form    = $this->createForm(
            'gravity_file',
            $file,
            [
                'method' => 'PUT',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->putEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof File) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            204,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_file',
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
     * @param Request $request
     * @param File    $file
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function patchAction(Request $request, File $file)
    {
        $service = $this->get('gravity.entity_service.file');
        $form    = $this->createForm(
            'gravity_file',
            $file,
            [
                'method' => 'PATCH',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->patchEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof File) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            204,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_file',
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
     * @param File $file
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(File $file)
    {
        $success = $this->deleteEntity(
            $this->get('gravity.entity_service.file'),
            $file
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
     * @param Request $request
     *
     * @return Response
     * @throws \GravityCMS\Component\Configuration\Exception\ConfigurationNotFoundException
     *
     * [GET] /api/file/settings.{_format}
     */
    public function putSettingsAction(Request $request)
    {
        $this->authenticate(self::METHOD_PUT);

        $configManager = $this->get('gravity_cms.config_manager');

        $config = $configManager->get('file:settings');
        $form   = $configManager->getForm(
            $config,
            [
                'method' => 'PUT',
            ]
        );

        $payload = json_decode($request->getContent(), true);

        $form->submit($payload[$form->getName()]);

        if ($form->isValid()) {
            $newConfig = $form->getData();

            $configManager->set($newConfig);

            $view = JsonApiView::create(
                null,
                200,
                [
                    'location' => $this->generateUrl('gravity_admin_file_settings'),
                ]
            );
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
