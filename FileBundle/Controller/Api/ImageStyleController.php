<?php

namespace Gravity\FileBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Gravity\FileBundle\Document\File as FileDocument;
use Gravity\FileBundle\Entity\ImageStyle;
use Gravity\FileBundle\Entity\ImageStyleOperation;
use Gravity\FileBundle\Form\FileFormType;
use Gravity\FileBundle\Form\GravityFileForm;
use Gravity\FileBundle\Model\File;
use Gravity\FileBundle\Model\FileCategory;
use GravityCMS\CoreBundle\Controller\Api\AbstractApiController;
use GravityCMS\CoreBundle\FosRest\View\View\JsonApiView;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * API for ImageStyle
 *
 * Class FileController
 *
 * @package Gravity\FileBundle\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleController extends AbstractApiController implements ClassResourceInterface
{
    /**
     * @return Form
     */
    function getForm()
    {
        return 'image_style';
    }

    /**
     * @return string
     */
    function getEntityClass()
    {
        return 'Gravity\FileBundle\Entity\ImageStyle';
    }

    /**
     * {@inheritdoc}
     */
    function getUrl($method, $entity = null)
    {
        switch ($method) {
            case self::METHOD_POST:
                return $this->generateUrl('gravity_api_post_image_style');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('gravity_api_put_image_style', ['id' => $entity->getId()]);
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('gravity_api_delete_image_style', ['id' => $entity->getId()]);
                break;

            case self::METHOD_GET:
                return $this->generateUrl('nefarian_plugin_content_management_content_type_edit',
                    ['id' => $entity->getId()]);
                break;
        }

        return '';
    }

    function hasPermission($method)
    {
        return true;
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

    public function postOperationAction(Request $request, ImageStyle $imageStyle)
    {
        $this->authenticate(self::METHOD_POST);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $payload = json_decode($request->getContent(), true);

        $class     = new ImageStyleOperation();
        $class->setImageStyle($imageStyle);

        $newEntity = new $class();
        $form      = $this->createForm('image_style_operation', $newEntity, [
            'method' => 'POST'
        ]);
        $form->submit($payload[$form->getName()]);

        if($form->isValid())
        {
            /** @var ImageStyleOperation $entity */
            $entity = $form->getData();

            $this->preCreate($entity);

            $imageStyleManager = $this->get('gravity.image_style_manager');
            $operation = $imageStyleManager->getOperation($entity->getType());

            $entity->setConfig($operation->getConfiguration());
            $entity->setImageStyle($imageStyle);

            $em->persist($entity);
            $em->flush();

            $this->postCreate($entity);

            $view = JsonApiView::create(null, 201, [
                'location' => $this->getUrl(self::METHOD_VIEW_ALL, $entity)
            ]);
        }
        else
        {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function putOperationSettingsAction(Request $request, ImageStyle $imageStyle, ImageStyleOperation $imageStyleOperation)
    {
        $this->authenticate(self::METHOD_POST);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $payload = json_decode($request->getContent(), true);

        $class     = $imageStyleOperation->getConfig();

        $newEntity = new $class();
        $form      = $this->createForm($class->getForm(), $newEntity, [
            'method' => 'POST'
        ]);
        $form->submit($payload[$form->getName()]);

        if($form->isValid())
        {
            /** @var ImageStyleOperation $entity */
            $entity = $form->getData();

            $imageStyleOperation->setConfig($entity);
            $this->preCreate($entity);

            $em->persist($imageStyleOperation);
            $em->flush();

            $this->postCreate($entity);

            $view = JsonApiView::create(null, 201, [
                'location' => $this->getUrl(self::METHOD_VIEW_ALL, $entity)
            ]);
        }
        else
        {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
