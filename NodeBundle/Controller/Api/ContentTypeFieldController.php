<?php

namespace Gravity\NodeBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use GravityCMS\CoreBundle\FosRest\View\View\JsonApiView;
use Gravity\NodeBundle\Entity\ContentType;
use Gravity\NodeBundle\Entity\ContentTypeField;
use Gravity\NodeBundle\Entity\ContentTypeFieldDisplay;
use Gravity\NodeBundle\Entity\ContentTypeFieldWidget;
use Gravity\NodeBundle\Field\Widget\WidgetSettingsInterface;
use Gravity\NodeBundle\Form\ContentTypeFieldForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContentTypeController
 *
 * @package Gravity\NodeBundle\Controller\Api
 *
 * @FOSRest\RouteResource("Field")
 */
class ContentTypeFieldController extends Controller implements ClassResourceInterface
{
    /**
     * @return Form
     */
    function getForm()
    {
        return new ContentTypeFieldForm();
    }

    /**
     * @return string
     */
    function getEntityClass()
    {
        return 'Gravity\NodeBundle\Entity\ContentType';
    }

    public function postAction(Request $request, ContentType $contentType)
    {
        /** @var EntityManager $em */

        $fieldConfigForm  = new ContentTypeFieldForm();
        $contentTypeField = new ContentTypeField();
        $contentTypeField->setContentType($contentType);

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $contentTypeField, array(
            'method' => 'POST',
        ));

        $label = $payload[$fieldConfigForm->getName()]['label'];
        $payload[$fieldConfigForm->getName()]['name']
               = strtolower(preg_replace(array('/[^a-zA-Z0-9 ]/', '/\s+/'), array('', '_'), $label));
        $form->submit($payload[$fieldConfigForm->getName()]);

        if ($form->isValid()) {
            $entity = $form->getData();

            if ($entity instanceof ContentTypeField) {
                $em = $this->getDoctrine()->getManager();

                $fieldManager    = $this->get('gravity_cms.field_manager');
                $fieldDefinition = $fieldManager->getField($entity->getField()->getName());
                $configClass     = $fieldDefinition->getSettings();
                $defaultConfig   = new $configClass();
                $entity->setConfig($defaultConfig);

                $fieldDisplay = $fieldDefinition->getDisplay();
                $viewDisplay  = new ContentTypeFieldDisplay();
                $viewDisplay->setName($fieldDisplay->getName());
                $viewDisplay->setLabel($fieldDisplay->getLabel());
                $viewDisplay->setConfig($fieldDisplay->getSettings());
                $viewDisplay->setTypeField($entity);
                $viewDisplay->setOrder(count($contentType->getContentTypeFields()));
                $em->persist($viewDisplay);
                $entity->setViewDisplay($viewDisplay);


                $fieldWidget = $fieldDefinition->getWidget();
                $viewWidget  = new ContentTypeFieldWidget();
                $viewWidget->setName($fieldWidget->getName());
                $viewWidget->setLabel($fieldWidget->getLabel());
                $viewWidget->setConfig($fieldWidget->getSettings());
                $viewWidget->setTypeField($entity);
                $viewWidget->setOrder(count($contentType->getContentTypeFields()));
                $em->persist($viewWidget);
                $entity->setViewWidget($viewWidget);

                $em->persist($entity);
                $em->flush();

                $view = JsonApiView::create(null, 302, array(
                    'location' => $this->generateUrl('gravity_admin_content_type_edit_field_settings',
                        array(
                            'type' => $contentType->getName(),
                            'typeField' => $contentTypeField->getName(),
                        )),
                ));
            }
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    public function putSettingsAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $config          = clone $contentTypeField->getConfig();
        $fieldConfigForm = $config->getForm();

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $config, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_type_field', array(
                'contentType' => $contentType->getId(),
                'contentTypeField' => $contentTypeField->getId(),
            )),
        ));

        $form->submit($payload[$fieldConfigForm->getName()]);

        if ($form->isValid()) {
            $entity = $form->getData();

            $contentTypeField->setConfig($entity);
            $em->persist($contentTypeField);
            $em->flush($contentTypeField);

            $view = JsonApiView::create(null, 200, array(
                'location' => $this->generateUrl('gravity_admin_content_type_edit_fields',
                    array('type' => $contentType->getName())),
            ));
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function patchWidgetAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $payload = json_decode($request->getContent(), true);

        $currentWidget = $contentTypeField->getViewWidget()->getName();

        $form = $this->createForm('gravity_node_content_type_field_view_change',
            array(
                'type' => $currentWidget
            ),
            array(
                'field'  => $contentTypeField->getField(),
                'method' => 'PATCH',
                'action' => $this->generateUrl('gravity_api_patch_type_field_widget', array(
                    'contentType' => $contentType->getId(),
                    'contentTypeField' => $contentTypeField->getId(),
                )),
                'attr' => array(
                    'class' => 'api-save',
                ),
            )
        );

        $form->submit($payload['gravity_node_content_type_field_view_change']);

        if ($form->isValid()) {
            $form = $form->getData();

            $fieldManager = $this->get('gravity_cms.field_manager');
            $widget = $fieldManager->getFieldWidget($form['type']);

            $widgetEntity = $contentTypeField->getViewWidget();
            $widgetEntity->setName($widget->getName());
            $widgetEntity->setLabel($widget->getLabel());
            $widgetEntity->setDescription($widget->getDescription());
            $config = $widget->getSettings();
            if($config instanceof WidgetSettingsInterface) {
                $widgetEntity->setConfig($widget->getSettings());
            } else {
                $widgetEntity->unsetConfig();
            }


            $em->persist($widgetEntity);
            $em->flush($widgetEntity);

            $view = JsonApiView::create(null, 200, array(
                'location' => $this->generateUrl('gravity_admin_content_type_edit_fields',
                    array('type' => $contentType->getName())),
            ));
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function putAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */

        $fieldConfigForm = new ContentTypeFieldForm();

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $contentTypeField, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_type_field', array(
                'contentType' => $contentType->getId(),
                'contentTypeField' => $contentTypeField->getId(),
            )),
        ));

        $form->remove('field');

        $form->submit($payload[$fieldConfigForm->getName()]);

        if ($form->isValid()) {
            $entity = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $view = JsonApiView::create(null, 200, array(
                'location' => $this->generateUrl('gravity_admin_content_type_edit_fields',
                    array('type' => $contentType->getName())),
            ));
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function deleteAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->remove($contentTypeField);
        $em->flush();

        $view = JsonApiView::create(null, 204);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /*public function postAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em * /
        $configManager = $this->get('gravity_cms.configuration_manager');

        $fieldConfigName = 'content_type.' . $contentType->getName() . '.' . $contentTypeField->getName();
        $fieldConfig     = $configManager->get($fieldConfigName);
        $fieldConfigForm = $configManager->getConfigForm($fieldConfigName);

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $fieldConfig, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_type_field', array(
                'contentType' => $contentType->getId(),
                'contentTypeField' => $contentTypeField->getId(),
            )),
        ));

        $form->submit($payload[$fieldConfigForm->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();
            $configManager->set($fieldConfigName, $entity);

            $view = JsonApiView::create(null, 201, array(
                'location' => $this->generateUrl('gravity_admin_content_type_edit_fields', array('type' => $contentType->getName())),
            ));
        }
        else
        {
            $view = JsonApiView::create($form);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }*/


    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch ($method) {
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

    public function hasPermission($method)
    {
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

} 
