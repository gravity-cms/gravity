<?php


namespace Gravity\FileBundle\Controller;

use Gravity\FileBundle\Entity\ImageStyle;
use Gravity\FileBundle\Entity\ImageStyleOperation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImageStyleController
 *
 * @package Gravity\FileBundle\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleController extends Controller
{
    /**
     * List all image styles
     *
     * @return Response
     */
    public function listAction()
    {
        $imageStyleManager = $this->get('gravity.image_style_manager');

        return $this->render('GravityFileBundle:ImageStyle:list.html.twig', [
            'image_styles' => $imageStyleManager->getImageStyles()
        ]);
    }

    /**
     * View an image style
     *
     * @param string $name
     *
     * @return Response
     */
    public function viewAction($name)
    {
        $imageStyleManager = $this->get('gravity.image_style_manager');

        return $this->render('GravityFileBundle:ImageStyle:view.html.twig', [
            'image_style' => $imageStyleManager->getImageStyle($name),
        ]);
    }
}
