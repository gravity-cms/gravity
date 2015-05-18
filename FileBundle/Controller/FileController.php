<?php

namespace Gravity\FileBundle\Controller;

use FOS\RestBundle\View\View;
use Gravity\FileBundle\Configuration\FileConfiguration;
use Gravity\FileBundle\Entity\File;
use Gravity\Component\Configuration\Exception\ConfigurationNotFoundException;
use Gravity\CoreBundle\FosRest\View\View\JsonApiView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class FileController
 *
 * @package Gravity\FileBundle\Controller
 */
class FileController extends Controller
{

    /**
     * List all file items
     *
     * @return Response
     * @throws AccessDeniedException
     */
    public function listAction()
    {
        $form = $this->createForm(
            'gravity_file',
            new File(),
            [
                'method' => 'POST',
                'action' => $this->generateUrl('gravity_api_post_file'),
            ]
        );

        return $this->render(
            'GravityFileBundle:Admin:list.html.twig',
            [
                'mime_types' => '*/*',
                'form' => $form->createView(),
            ]
        );

    }

    /**
     * Edit a file entity
     *
     * @param $id
     *
     * @return Response
     * @throws AccessDeniedException
     */
    public function editAction($id)
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin'))) {
            throw new AccessDeniedException();
        }

        $fileManager = $this->get('linestorm.cms.file_manager');
        $provider    = $fileManager->getDefaultProviderInstance();

        $file = $fileManager->find($id);

        $form = $this->createForm(
            $provider->getForm(),
            $file,
            [
                'action' => $this->generateUrl('gravity_api_put_file', ['id' => $file->getId()]),
                'method' => 'PUT',
            ]
        );

        return $this->render(
            'LineStormFileBundle:Admin:edit.html.twig',
            [
                'image' => $file,
                'form'  => $form->createView(),
            ]
        );
    }

    /**
     * Create a file entity
     *
     * @return Response
     * @throws AccessDeniedException
     */
    public function newAction()
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin'))) {
            throw new AccessDeniedException();
        }

        $fileManager = $this->get('linestorm.cms.file_manager');
        $provider    = $fileManager->getDefaultProviderInstance();
        $class       = $provider->getEntityClass();

        $form = $this->createForm(
            'linestorm_cms_form_file_multiple',
            null,
            [
                'action' => $this->generateUrl('gravity_api_post_file_batch'),
                'method' => 'POST',
            ]
        );

        return $this->render(
            'LineStormFileBundle:Admin:new.html.twig',
            [
                'image' => null,
                'form'  => $form->createView(),
            ]
        );
    }

    /**
     * Upload a file entity
     *
     * @param Request $request
     *
     * @return Response
     */
    public function uploadAction(Request $request)
    {
        // TODO: permissions!
        //        $user = $this->getUser();
        //        if (!($user instanceof UserInterface) || !($user->hasGroup('admin'))) {
        //            throw new AccessDeniedException();
        //        }

        $fileManager = $this->get('gravity.file_manager');

        try {
            $files = $request->files->all();
            /** @var UploadedFile $file */
            $file = array_shift($files);

            $newFile = $fileManager->upload($file);

            $view = JsonApiView::create(
                $newFile,
                201,
                [
                    'GRAVITY-API-GET' => $this->generateUrl('gravity_api_post_file'),
                ]
            );
            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        }
        catch (\Exception $e) {
            $view = View::create(
                [
                    'error' => $e->getMessage(),
                ],
                400
            );
            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        };


    }
}
