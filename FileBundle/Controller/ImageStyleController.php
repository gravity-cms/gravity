<?php


namespace Gravity\FileBundle\Controller;

use Gravity\FileBundle\Entity\ImageStyle;
use Gravity\FileBundle\Entity\ImageStyleOperation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ImageStyleController
 *
 * @package Gravity\FileBundle\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imageStyles = $em->getRepository('GravityFileBundle:ImageStyle')->findAll();

        return $this->render('GravityFileBundle:ImageStyle:list.html.twig', [
            'image_styles' => $imageStyles
        ]);
    }

    public function newAction()
    {
        $form = $this->createForm('image_style', null, [
            'method' => 'POST',
            'action' => $this->generateUrl('gravity_api_post_image_style'),
            'attr'   => [
                'class' => 'api-save'
            ],
        ]);

        return $this->render('GravityFileBundle:ImageStyle:new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param ImageStyle $imageStyle
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Config\ParamConverter("imageStyle", options={"mapping": {"imageStyle" = "name"}})
     */
    public function editAction(ImageStyle $imageStyle)
    {
        $form = $this->createForm('image_style', $imageStyle, [
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_post_image_style'),
            'attr'   => [
                'class' => 'api-save'
            ],
        ]);

        return $this->render('GravityFileBundle:ImageStyle:edit.html.twig', [
            'form'        => $form->createView(),
            'image_style' => $imageStyle,
        ]);
    }

    /**
     * @param ImageStyle $imageStyle
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Config\ParamConverter("imageStyle", options={"mapping": {"imageStyle" = "name"}})
     */
    public function newOperationAction(ImageStyle $imageStyle)
    {
        $imageStyleOperation = new ImageStyleOperation();
        $imageStyleOperation->setImageStyle($imageStyle);
        $imageStyleOperation->setDelta(count($imageStyle->getOperations()));

        $form = $this->createForm('image_style_operation', $imageStyleOperation, [
            'method' => 'POST',
            'action' => $this->generateUrl('gravity_api_post_image_style_operation', [
                'imageStyle' => $imageStyle->getId(),
            ]),
            'attr'   => [
                'class' => 'api-save'
            ],
        ]);

        return $this->render('GravityFileBundle:ImageStyle:new-operation.html.twig', [
            'form'        => $form->createView(),
            'image_style' => $imageStyle,
        ]);
    }

    /**
     * @param ImageStyle          $imageStyle
     * @param ImageStyleOperation $imageStyleOperation
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Config\ParamConverter("imageStyle", options={"mapping": {"imageStyle" = "name"}})
     * @Config\ParamConverter("imageStyleOperation", options={"mapping": {"imageStyleOperation" = "name"}})
     */
    public function editOperationAction(ImageStyle $imageStyle, ImageStyleOperation $imageStyleOperation)
    {
        $form = $this->createForm('image_style_operation', $imageStyleOperation, [
            'method' => 'POST',
            'action' => $this->generateUrl('gravity_api_post_image_style_operation', [
                'imageStyle' => $imageStyle->getId(),
            ]),
            'attr'   => [
                'class' => 'api-save'
            ],
        ]);

        return $this->render('GravityFileBundle:ImageStyle:edit-operation.html.twig', [
            'form'                  => $form->createView(),
            'image_style'           => $imageStyle,
            'image_style_operation' => $imageStyleOperation,
        ]);
    }

    /**
     * @param ImageStyle          $imageStyle
     * @param ImageStyleOperation $imageStyleOperation
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Config\ParamConverter("imageStyle", options={"mapping": {"imageStyle" = "name"}})
     * @Config\ParamConverter("imageStyleOperation", options={"mapping": {"imageStyleOperation" = "name"}})
     */
    public function editOperationSettingsAction(ImageStyle $imageStyle, ImageStyleOperation $imageStyleOperation)
    {
        $config = $imageStyleOperation->getConfig();
        $form   = $config->getForm();
        $form   = $this->createForm($form, $config, [
            'method' => 'PUT',
            'action' => $this->generateUrl('gravity_api_put_image_style_operation_settings', [
                'imageStyle'          => $imageStyle->getId(),
                'imageStyleOperation' => $imageStyleOperation->getId(),
            ]),
            'attr'   => [
                'class' => 'api-save'
            ],
        ]);

        return $this->render('GravityFileBundle:ImageStyle:edit-operation-settings.html.twig', [
            'form'                  => $form->createView(),
            'image_style'           => $imageStyle,
            'image_style_operation' => $imageStyleOperation,
        ]);
    }
}
