<?php

namespace Gravity\NodeBundle\Controller;

use Gravity\NodeBundle\Entity\ContentType;
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

        $form = $this->createForm(
            $formClass,
            $formConfig,
            [
                'attr'         => [
                    'class' => 'api-save'
                ],
                'field_config' => $field->getConfig(),
                'method'       => 'PUT',
                'action'       => $this->generateUrl(
                    'gravity_api_put_field_widget_settings',
                    [
                        'field'  => $field->getId(),
                        'widget' => $field->getWidget()->getId(),
                    ]
                ),
            ]
        );

        return $this->render(
            'GravityNodeBundle:ContentType:edit-tab-form-view-settings.html.twig',
            [
                'contentType' => $contentType,
                'field'       => $field,
                'form'        => $form->createView(),
            ]
        );
    }


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
    public function changeFormViewAction(
        Request $request,
        ContentType $contentType,
        Field $field
    ) {
        $currentWidget = $field->getWidget()->getName();

        $form = $this->createForm(
            'gravity_node_content_type_field_view_change',
            [
                'type' => $currentWidget
            ],
            [
                'field'  => $field,
                'method' => 'POST',
                'action' => $this->generateUrl(
                    'gravity_api_post_field_widget',
                    [
                        'field' => $field->getId(),
                    ]
                ),
                'attr'   => [
                    'class' => 'api-save',
                ],
            ]
        );

        return $this->render(
            'GravityNodeBundle:ContentType:edit-tab-form-change.html.twig',
            [
                'contentType' => $contentType,
                'field'       => $field,
                'form'        => $form->createView(),
            ]
        );
    }
}
