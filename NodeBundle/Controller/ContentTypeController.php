<?php

namespace Gravity\NodeBundle\Controller;

use Doctrine\ORM\EntityManager;
use Gravity\NodeBundle\Entity\ContentType;
use Gravity\NodeBundle\Entity\ContentTypeField;
use GravityCMS\CoreBundle\Entity\Field;
use Gravity\NodeBundle\Form\ContentTypeFieldForm;
use Gravity\NodeBundle\Form\ContentTypeForm;
use Gravity\NodeBundle\Form\ContentTypeFormViewForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ContentTypeController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em           = $this->getDoctrine()->getManager();
        $contentTypes = $em->getRepository('GravityNodeBundle:ContentType')->findAll();

        return $this->render(
            'GravityNodeBundle:ContentType:index.html.twig',
            array(
                'contentTypes' => $contentTypes,
            )
        );
    }

    /**
     * Create a form for a new content type
     *
     * @return Response
     */
    public function newAction()
    {
        $newContentType = new ContentType();

        $form = $this->createForm(
            new ContentTypeForm(),
            $newContentType,
            array(
                'attr' => array(
                    'class' => 'api-save'
                ),
                'method' => 'POST',
                'action' => $this->generateUrl('gravity_api_post_type'),
            )
        );

        return $this->render(
            'GravityNodeBundle:ContentType:new.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param ContentType $contentType
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     */
    public function editAction(ContentType $contentType)
    {
        $form = $this->createForm(
            new ContentTypeForm(),
            $contentType,
            array(
                'attr' => array(
                    'class' => 'api-save'
                ),
                'method' => 'PUT',
                'action' => $this->generateUrl('gravity_api_put_type',
                    array('id' => $contentType->getId())),
            )
        );

        return $this->render(
            'GravityNodeBundle:ContentType:edit-tab-content-type.html.twig',
            array(
                'contentType' => $contentType,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param ContentType $contentType
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     */
    public function editFieldsAction(ContentType $contentType)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $contentTypeFieldForm = new ContentTypeFieldForm();
        $contentTypeFields = new ContentTypeField();
        $contentTypeFields->setOrder(count($contentType->getContentTypeFields()));
        $form = $this->createForm($contentTypeFieldForm, $contentTypeFields, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'POST',
            'action' => $this->generateUrl('gravity_api_post_type_field', array(
                'contentType' => $contentType->getId(),
            )),
        ));

        $form->remove('name');

        $fields = $em->getRepository('GravityCMSCoreBundle:Field')->findAll();

        return $this->render(
            'GravityNodeBundle:ContentType:edit-tab-fields.html.twig',
            array(
                'contentType' => $contentType,
                'fields' => $fields,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param ContentType      $contentType
     * @param ContentTypeField $contentTypeField
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     * @ParamConverter("contentTypeField", options={"mapping": {"typeField" = "name"}})
     */
    public function editFieldAction(ContentType $contentType, ContentTypeField $contentTypeField)
    {
        $form = $this->createForm(
            new ContentTypeFieldForm(),
            $contentTypeField,
            array(
                'attr' => array(
                    'class' => 'api-save'
                ),
                'method' => 'PUT',
                'action' => $this->generateUrl('gravity_api_put_type_field', array(
                    'contentType' => $contentType->getId(),
                    'contentTypeField' => $contentTypeField->getId(),
                )),
            )
        );

        $form->remove('field');

        return $this->render(
            'GravityNodeBundle:ContentType:edit-tab-field-edit.html.twig',
            array(
                'contentType' => $contentTypeField->getContentType(),
                'contentTypeField' => $contentTypeField,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param ContentType      $contentType
     * @param ContentTypeField $contentTypeField
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     * @ParamConverter("contentTypeField", options={"mapping": {"typeField" = "name"}})
     */
    public function editFieldSettingsAction(ContentType $contentType, ContentTypeField $contentTypeField)
    {
        $config = $contentTypeField->getConfig();
        $form   = $config->getForm();

        $form = $this->createForm($form, $config, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_type_field_settings', array(
                'contentType' => $contentType->getId(),
                'contentTypeField' => $contentTypeField->getId(),
            )),
        ));

        return $this->render(
            'GravityNodeBundle:ContentType:edit-tab-field-settings.html.twig',
            array(
                'contentType' => $contentType,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param ContentType      $contentType
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     */
    public function editFormViewAction(ContentType $contentType)
    {
        $form = $this->createForm(new ContentTypeFormViewForm(), $contentType, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_type_form_view', array(
                'id' => $contentType->getId(),
            )),
        ));

        return $this->render(
            'GravityNodeBundle:ContentType:edit-tab-form-view.html.twig',
            array(
                'contentType' => $contentType,
                'form' => $form->createView(),
            )
        );
    }

} 
