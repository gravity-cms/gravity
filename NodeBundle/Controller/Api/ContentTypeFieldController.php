<?php

namespace Gravity\NodeBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Gravity\NodeBundle\Entity\ContentType;
use GravityCMS\Component\Field\Widget\WidgetSettingsInterface;
use GravityCMS\CoreBundle\Entity\Field;
use GravityCMS\CoreBundle\Entity\FieldDisplay;
use GravityCMS\CoreBundle\Entity\FieldWidget;
use GravityCMS\CoreBundle\FosRest\View\View\JsonApiView;
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
        $em = $this->getDoctrine()->getManager();

        $payload = json_decode($request->getContent(), true);

        $field = new Field();
        $form  = $this->createForm('gravity_field', $field, [
            'method' => 'POST',
        ]);

        $label = $payload['gravity_field']['label'];
        $payload['gravity_field']['name']
               = strtolower(preg_replace(['/[^a-zA-Z0-9 ]/', '/\s+/'], ['', '_'], $label));
        $form->submit($payload['gravity_field']);

        if ($form->isValid()) {
            $entity = $form->getData();

            if ($entity instanceof Field) {

                $contentType->addField($entity);

                $fieldManager    = $this->get('gravity_cms.field_manager');
                $fieldDefinition = $fieldManager->getField($entity->getFieldType());
                $configClass     = $fieldDefinition->getSettings();
                $defaultConfig   = new $configClass();
                $entity->setConfig($defaultConfig);

                $fieldDisplay = $fieldDefinition->getDisplay();
                $viewDisplay  = new FieldDisplay();
                $viewDisplay->setName($fieldDisplay->getName());
                $viewDisplay->setLabel($fieldDisplay->getLabel());
                $viewDisplay->setConfig($fieldDisplay->getSettings());
                $viewDisplay->setDelta(count($contentType->getFields()));
                $em->persist($viewDisplay);
                $entity->setDisplay($viewDisplay);


                $fieldWidget = $fieldDefinition->getWidget();
                $viewWidget  = new FieldWidget();
                $viewWidget->setName($fieldWidget->getName());
                $viewWidget->setLabel($fieldWidget->getLabel());
                $viewWidget->setConfig($fieldWidget->getSettings());
                $viewWidget->setDelta(count($contentType->getFields()));
                $em->persist($viewWidget);
                $entity->setWidget($viewWidget);

                $em->persist($entity);
                $em->flush();

                $view = JsonApiView::create(null, 302, [
                    'location' => $this->generateUrl('gravity_admin_content_type_edit_field_settings',
                        [
                            'type'  => $contentType->getName(),
                            'field' => $entity->getName(),
                        ]),
                ]);
            }
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    public function putSettingsAction(Request $request, ContentType $contentType, Field $field)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $config          = clone $field->getConfig();
        $fieldConfigForm = $config->getForm();

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $config, [
            'attr'   => [
                'class' => 'api-save'
            ],
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_type_field', [
                'contentType' => $contentType->getId(),
                'field'       => $field->getId(),
            ]),
        ]);

        $form->submit($payload[$fieldConfigForm->getName()]);

        if ($form->isValid()) {
            $entity = $form->getData();

            $field->setConfig($entity);
            $em->persist($field);
            $em->flush($field);

            $view = JsonApiView::create(null, 200, [
                'location' => $this->generateUrl('gravity_admin_content_type_edit_fields',
                    ['type' => $contentType->getName()]),
            ]);
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function patchWidgetAction(Request $request, ContentType $contentType, Field $field)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $payload = json_decode($request->getContent(), true);

        $currentWidget = $field->getWidget()->getName();

        $form = $this->createForm('gravity_node_content_type_field_view_change',
            [
                'type' => $currentWidget
            ],
            [
                'field'  => $field,
                'method' => 'PATCH',
                'action' => $this->generateUrl('gravity_api_patch_type_field_widget', [
                    'contentType' => $contentType->getId(),
                    'field'       => $field->getId(),
                ]),
                'attr'   => [
                    'class' => 'api-save',
                ],
            ]
        );

        $form->submit($payload['gravity_node_content_type_field_view_change']);

        if ($form->isValid()) {
            $form = $form->getData();

            $fieldManager = $this->get('gravity_cms.field_manager');
            $widget       = $fieldManager->getFieldWidget($form['type']);

            $widgetEntity = $field->getWidget();
            $widgetEntity->setName($widget->getName());
            $widgetEntity->setLabel($widget->getLabel());
            $widgetEntity->setDescription($widget->getDescription());
            $config = $widget->getSettings();
            if ($config instanceof WidgetSettingsInterface) {
                $widgetEntity->setConfig($widget->getSettings());
            } else {
                $widgetEntity->unsetConfig();
            }


            $em->persist($widgetEntity);
            $em->flush($widgetEntity);

            $view = JsonApiView::create(null, 200, [
                'location' => $this->generateUrl('gravity_admin_content_type_edit_fields',
                    ['type' => $contentType->getName()]),
            ]);
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function putAction(Request $request, ContentType $contentType, Field $field)
    {
        /** @var EntityManager $em */

        $fieldConfigForm = new ContentTypeFieldForm();

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $field, [
            'attr'   => [
                'class' => 'api-save'
            ],
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_type_field', [
                'contentType' => $contentType->getId(),
                'field'       => $field->getId(),
            ]),
        ]);

        $form->remove('field');

        $form->submit($payload[$fieldConfigForm->getName()]);

        if ($form->isValid()) {
            $entity = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $view = JsonApiView::create(null, 200, [
                'location' => $this->generateUrl('gravity_admin_content_type_edit_fields',
                    ['type' => $contentType->getName()]),
            ]);
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function deleteAction(Request $request, ContentType $contentType, Field $field)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->remove($field);
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
                return $this->generateUrl('gravity_api_put_type', ['id' => $entity->getId()]);
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('gravity_api_delete_type',
                    ['id' => $entity->getId()]);
                break;

            case self::METHOD_GET:
                return $this->generateUrl('gravity_admin_content_type_edit',
                    ['type' => $entity->getName()]);
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
