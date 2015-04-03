<?php

namespace Gravity\NodeBundle\Controller;

use Gravity\NodeBundle\Entity\ContentType;
use Gravity\NodeBundle\Entity\ContentTypeField;
use GravityCMS\CoreBundle\Entity\Field;
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
     * @param Request     $request
     * @param ContentType $contentType
     * @param Field       $field
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Config\ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     * @Config\ParamConverter("field", options={"mapping": {"field" = "name"}})
     */
    public function editFormViewSettingsAction(
        Request $request,
        ContentType $contentType,
        Field $field
    ) {
        $formConfig = $field->getWidget()->getConfig();
        $formClass  = $formConfig->getForm();
        $formType   = new $formClass();

        $form = $this->createForm($formType, $formConfig, []);

        return $this->render('GravityNodeBundle:ContentType:edit-tab-form-view-settings.html.twig', [
            'contentType' => $contentType,
            'field'       => $field,
            'form'        => $form->createView(),
        ]);
    }


    /**
     * @param Request          $request
     * @param ContentType      $contentType
     * @param Field $field
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Config\ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     * @Config\ParamConverter("field", options={"mapping": {"field" = "name"}})
     */
    public function changeFormViewAction(
        Request $request,
        ContentType $contentType,
        Field $field
    ) {
        $currentWidget = $field->getWidget()->getName();

        $form = $this->createForm('gravity_node_content_type_field_view_change',
            [
                'type' => $currentWidget
            ],
            [
                'field'  => $field,
                'method' => 'PATCH',
                'action' => $this->generateUrl('gravity_api_patch_type_field_widget', [
                    'contentType'      => $contentType->getId(),
                    'field' => $field->getId(),
                ]),
                'attr'   => [
                    'class' => 'api-save',
                ],
            ]
        );

        return $this->render('GravityNodeBundle:ContentType:edit-tab-form-change.html.twig', [
            'contentType'   => $contentType,
            'field'         => $field,
            'form'          => $form->createView(),
        ]);
    }
}
