<?php

namespace Gravity\CoreBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gravity\Component\Field\Display\DisplaySettingsInterface;
use Gravity\CoreBundle\Entity\Field;
use Gravity\CoreBundle\Entity\FieldDisplay;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FieldDisplayController
 *
 * @package Gravity\CoreBundle\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldDisplayController extends Controller implements ClassResourceInterface
{
    use ApiEntityServiceControllerTrait;

    /**
     * [PUT] Update an existing entity
     *
     * @param Request      $request
     * @param Field        $field
     * @param FieldDisplay $display
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSettingsAction(Request $request, Field $field, FieldDisplay $display)
    {
        $service = $this->get('gravity.entity_service.field_display');

        $config  = clone $display->getConfig();
        $form    = $this->createForm(
            $config->getForm(),
            $config,
            [
                'method' => 'PUT',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->putConfig($service, $field, $form, $payload[$form->getName()]);

        if (!$entity instanceof DisplaySettingsInterface) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(null, 201);
    }

    /**
     * [PATCH] Partial update an existing entity
     *
     * @param Request      $request
     * @param Field        $field
     * @param FieldDisplay $display
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function patchSettingsAction(Request $request, Field $field, FieldDisplay $display)
    {
        $service = $this->get('gravity.entity_service.field_display');

        $config  = clone $display->getConfig();
        $form    = $this->createForm(
            $config->getForm(),
            $config,
            [
                'method' => 'PUT',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->patchConfig($service, $field, $form, $payload[$form->getName()]);

        if (!$entity instanceof DisplaySettingsInterface) {
            return $this->jsonResponse($form, 400);
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(null, 201);
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
