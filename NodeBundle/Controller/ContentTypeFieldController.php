<?php

namespace Gravity\NodeBundle\Controller;

use Gravity\NodeBundle\Entity\ContentType;
use Gravity\NodeBundle\Entity\ContentTypeField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContentTypeFieldController
 *
 * @package Gravity\NodeBundle\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentTypeFieldController extends Controller
{
    /**
     * @param Request          $request
     * @param ContentType      $contentType
     * @param ContentTypeField $contentTypeField
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Config\ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     * @Config\ParamConverter("contentTypeField", options={"mapping": {"typeField" = "name"}})
     */
    public function editFormViewSettingsAction(
        Request $request,
        ContentType $contentType,
        ContentTypeField $contentTypeField
    ) {
        $formConfig = $contentTypeField->getViewWidget()->getConfig();
        $formClass  = $formConfig->getForm();
        $formType   = new $formClass();

        $form = $this->createForm($formType, $formConfig, array());

        return $this->render('GravityNodeBundle:ContentType:edit-tab-form-view-settings.html.twig', array(
            'contentType'      => $contentType,
            'contentTypeField' => $contentTypeField,
            'form'             => $form->createView(),
        ));
    }


    /**
     * @param Request          $request
     * @param ContentType      $contentType
     * @param ContentTypeField $contentTypeField
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Config\ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     * @Config\ParamConverter("contentTypeField", options={"mapping": {"typeField" = "name"}})
     */
    public function changeFormViewAction(
        Request $request,
        ContentType $contentType,
        ContentTypeField $contentTypeField
    ) {
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

        return $this->render('GravityNodeBundle:ContentType:edit-tab-form-change.html.twig', array(
            'contentType'      => $contentType,
            'contentTypeField' => $contentTypeField,
            'form'             => $form->createView(),
        ));
    }
}
