<?php

namespace Gravity\NodeBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use GravityCMS\CoreBundle\Controller\Api\AbstractApiController;
use GravityCMS\CoreBundle\FosRest\View\View\JsonApiView;
use Gravity\NodeBundle\Form\ContentTypeForm;
use Gravity\NodeBundle\Form\ContentTypeFormViewForm;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContentTypeController
 *
 * @package Gravity\NodeBundle\Controller\Api
 *
 * @FOSRest\RouteResource("Type")
 */
class ContentTypeController extends AbstractApiController implements ClassResourceInterface
{
    /**
     * @return Form
     */
    function getForm()
    {
        return new ContentTypeForm();
    }

    /**
     * @return string
     */
    function getEntityClass()
    {
        return 'Gravity\NodeBundle\Entity\ContentType';
    }

    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch ($method) {
            case self::METHOD_VIEW_ALL:
                return $this->generateUrl('gravity_admin_content_type_manage');
                break;

            case self::METHOD_POST:
                return $this->generateUrl('gravity_api_post_type');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('gravity_api_put_type', array('id' => $entity->getId()));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('gravity_api_delete_type',
                    array('id' => $entity->getId()));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('gravity_admin_content_type_edit',
                    array('type' => $entity->getName()));
                break;
        }

        return '';
    }

    function hasPermission($method)
    {
        return true;
        $this->get('security.acl.provider');
        $userManager = $this->get('nefarian_core.user_manager');
        switch ($method) {
            case self::METHOD_NEW:
            case self::METHOD_POST:
                return $userManager->hasPermission($this->getUser(), 'content.type.create');
                break;

            case self::METHOD_EDIT:
            case self::METHOD_PUT:
                return $userManager->hasPermission($this->getUser(), 'content.type.update');
                break;

            case self::METHOD_DELETE:
                return $userManager->hasPermission($this->getUser(), 'content.type.delete');
                break;

            case self::METHOD_GET:
                return $userManager->hasPermission($this->getUser(), 'content.type.get');
                break;
        }

        return false;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putFormViewAction(Request $request, $id)
    {
        $this->authenticate(self::METHOD_PUT);

        /** @var EntityManager $em */
        $class  = $this->getEntityClass();
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository($class)->find($id);

        if (!$entity instanceof $class) {
            throw $this->createNotFoundException('Entity Not Found');
        }

        $payload = json_decode($request->getContent(), true);

        $formType = new ContentTypeFormViewForm();
        $form     = $this->createForm($formType, $entity);
        $form->submit($payload[$formType->getName()]);

        if ($form->isValid()) {
            $entity = $form->getData();

            $this->preUpdate($entity);

            $em->persist($entity);
            $em->flush();

            $this->postUpdate($entity);

            $view = JsonApiView::create(null, 201, array(
                'location' => $this->generateUrl('gravity_admin_content_type_edit_form_view',
                    array(
                        'type' => $entity->getName()
                    ))
            ));
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }


} 
