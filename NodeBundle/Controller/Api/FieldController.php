<?php

namespace Gravity\NodeBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gravity\NodeBundle\Entity\ContentType;
use GravityCMS\CoreBundle\Controller\Api\ApiEntityServiceControllerTrait;
use GravityCMS\CoreBundle\Entity\Field;
use GravityCMS\CoreBundle\Entity\Service\EntityServiceInterface;
use GravityCMS\CoreBundle\Form\FieldForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FieldController
 *
 * @package Gravity\NodeBundle\Controller\Api
 *
 * @FOSRest\RouteResource("Field")
 */
class FieldController extends Controller implements ClassResourceInterface
{
    use ApiEntityServiceControllerTrait;

    /**
     * @return Form
     */
    function getForm()
    {
        return new FieldForm();
    }

    /**
     * Get the entity name
     *
     * @return EntityServiceInterface
     */
    protected function getEntityService()
    {
        return $this->get('gravity.entity_service.field');
    }

    /**
     * [POST] Create a new Field for a ContentType
     *
     * @param Request     $request
     * @param ContentType $contentType
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request, ContentType $contentType)
    {

        $service = $this->get('gravity.entity_service.field');
        $field   = $service->create();

        $form    = $this->createForm(
            'gravity_field',
            $field,
            [
                'method' => 'POST',
            ]
        );
        $payload = json_decode($request->getContent(), true);

        $entity = $this->postEntity($service, $form, $payload[$form->getName()]);

        if (!$entity instanceof Field) {
            return $this->jsonResponse($form, 400);
        }

        $contentType->addField($field);
        $this->getDoctrine()->getManager()->flush();

        return $this->jsonResponse(
            null,
            201,
            [
                'location' => $this->generateUrl(
                    'gravity_api_get_field',
                    [
                        'field' => $entity->getId(),
                    ]
                )
            ]
        );
    }

    /**
     * [DELETE] Delete a Field entity
     *
     * @param ContentType $contentType
     * @param Field       $field
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(ContentType $contentType, Field $field)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $contentType->removeField($field);
        $em->persist($contentType);

        $success = $this->deleteEntity(
            $this->get('gravity.entity_service.field'),
            $field
        );

        if($success){
            $em->flush();
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

    public function hasPermission($method)
    {
        return true;
        // TODO: permissions
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
