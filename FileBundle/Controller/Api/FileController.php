<?php

namespace Gravity\FileBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Gravity\FileBundle\Document\File as FileDocument;
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
 * API for File
 *
 * Class FileController
 *
 * @package Gravity\FileBundle\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileController extends AbstractApiController implements ClassResourceInterface
{
    /**
     * @return Form
     */
    function getForm()
    {
        return new GravityFileForm();
    }

    /**
     * @return string
     */
    function getEntityClass()
    {
        return 'Gravity\FileBundle\Entity\File';
    }

    /**
     * {@inheritdoc}
     */
    function getUrl($method, $entity = null)
    {
        switch ($method) {
            case self::METHOD_POST:
                return $this->generateUrl('nefarian_api_content_management_post_type');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('nefarian_api_content_management_put_type', ['id' => $entity->getId()]);
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('nefarian_api_content_management_delete_type', ['id' => $entity->getId()]);
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


    /**
     * Resize a file object into all profiles
     *
     * @param $id
     *
     * @return Response
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     *
     * [PATCH] /api/file/{id}/resize.{_format}
     */
    public function resizeAction($id)
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin'))) {
            $view = View::create(new ApiExceptionResponse('Access Denied', 403));

            return $this->get('fos_rest.view_handler')->handle($view);
        }

        $fileManager = $this->get('linestorm.cms.file_manager');

        $provider = $this->getRequest()->query->get('p', null);

        $image = $fileManager->find($id, $provider);

        if (!($image instanceof File)) {
            throw $this->createNotFoundException("File not found");
        }

        $resizedImages = $fileManager->resize($image, $provider);

        $docs = [];
        foreach ($resizedImages as $resizedImage) {
            $docs[] = $this->getFileDocument($resizedImage);
        }

        $view = View::create($docs);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Search for a file entity
     *
     * @return Response
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     *
     * [GET] /api/file/search/?q={query}
     */
    public function searchAction()
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin'))) {
            $view = View::create(new ApiExceptionResponse('Access Denied', 403));

            return $this->get('fos_rest.view_handler')->handle($view);
        }

        $fileManager = $this->get('linestorm.cms.file_manager');
        $provider    = $this->getRequest()->query->get('p', null);

        $query  = $this->getRequest()->query->get('q', null);
        $images = $fileManager->search($query, $provider);

        $view = View::create($images);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    // BATCH METHODS

    /**
     * Create a batch of file entities
     *
     * @throws AccessDeniedException
     * @throws BadRequestHttpException
     * @return Response
     *
     * [POST] /blog/api/file/batches.{_format}
     */
    public function postBatchAction()
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin'))) {
            $view = View::create(new ApiExceptionResponse('Access Denied', 403));

            return $this->get('fos_rest.view_handler')->handle($view);
        }

        $fileManager = $this->get('linestorm.cms.file_manager');

        $request = $this->getRequest();
        $form    = $this->createForm('linestorm_cms_form_file_multiple');

        $payload = json_decode($request->getContent(), true);

        if (!array_key_exists('linestorm_cms_form_file_multiple', $payload)) {
            throw new BadRequestHttpException("Expected form does not exist");
        }

        $form->submit($payload['linestorm_cms_form_file_multiple']);

        if ($form->isValid()) {
            $updatedFile = $form->getData();
            $fileDocs    = [];

            /** @var File $file */
            foreach ($updatedFile['file'] as $file) {
                $file->setUploader($this->getUser());
                $fileManager->store($file);
                $fileManager->resize($file);

                $fileDocs[] = new FileDocument($file);
            }

            $view = $this->createResponse([], 200);
        } else {
            $view = $this->createResponse($form);
        }


        return $this->get('fos_rest.view_handler')->handle($view);

    }

    /**
     * Batch put file
     *
     * @param $id
     *
     * @throws AccessDeniedException
     * @return Response
     */
    public function putBatchAction($id)
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin'))) {
            $view = View::create(new ApiExceptionResponse('Access Denied', 403));

            return $this->get('fos_rest.view_handler')->handle($view);
        }

        $fileManager = $this->get('linestorm.cms.file_manager');

        $provider = $fileManager->getDefaultProviderInstance();

        $form = $this->createForm('linestorm_cms_form_file_multiple', null, [
            'action' => $this->generateUrl('gravity_api_post_file'),
            'method' => 'POST',
        ]);

        return $this->render('LineStormFileBundle:Form:multiple.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * Get all file, given a tree and/or node list
     *
     * @param Request $request
     *
     * @return Response
     * @throws NotFoundHttpException
     *
     * [GET] /api/file/tree/expanded.{_format}
     */
    public function getTreeExpandedAction(Request $request)
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin'))) {
            $view = View::create(new ApiExceptionResponse('Access Denied', 403));

            return $this->get('fos_rest.view_handler')->handle($view);
        }

        $nodes      = $request->query->get('nodes', []);
        $categories = $request->query->get('categories', []);

        $modelManager = $this->getModelManager();
        $repo         = $modelManager->get('file');
        $catRepo      = $modelManager->get('file_category');

        $nodeList = [];
        if (is_array($nodes)) {
            $qb = $repo->createQueryBuilder('m')
                ->where('m.id IN (:ids)')->setParameter('ids', $nodes);

            /** @var File[] $nodes */
            $nodes = $qb->getQuery()->getResult();
            foreach ($nodes as $node) {
                $nodeList[$node->getId()] = new FileDocument($node);
            }
        }

        if (is_array($categories)) {
            $hasChildren = true;
            while ($hasChildren) {
                $qb = $catRepo->createQueryBuilder('c')
                    ->leftJoin('c.file', 'm')->addSelect('m')
                    ->leftJoin('c.children', 'ch')->addSelect('partial ch.{id}')
                    ->where('c.id IN (:ids)')->setParameter('ids', $categories);

                /** @var FileCategory[] $catList */
                $catList    = $qb->getQuery()->getResult();
                $categories = []; // reset the id list
                foreach ($catList as $cat) {
                    foreach ($cat->getFile() as $node) {
                        $nodeList[$node->getId()] = new FileDocument($node);
                    }

                    foreach ($cat->getChildren() as $child) {
                        $categories[] = $child->getId();
                    }
                }

                if (!count($categories)) {
                    $hasChildren = false;
                }
            }

        }

        $view = View::create(array_values($nodeList));

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws \GravityCMS\Component\Configuration\Exception\ConfigurationNotFoundException
     *
     * [GET] /api/file/settings.{_format}
     */
    public function putSettingsAction(Request $request)
    {
        $this->authenticate(self::METHOD_PUT);

        $configManager = $this->get('gravity_cms.config_manager');

        $config = $configManager->get('file:settings');
        $form = $configManager->getForm($config, [
            'method' => 'PUT',
        ]);

        $payload = json_decode($request->getContent(), true);

        $form->submit($payload[$form->getName()]);

        if($form->isValid())
        {
            $newConfig = $form->getData();

            $configManager->set($newConfig);

            $view = JsonApiView::create(null, 200, [
                'location' => $this->generateUrl('gravity_admin_file_settings'),
            ]);
        }
        else
        {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Convert the file object to a document safe of the API
     *
     * @param File $file
     *
     * @return FileDocument
     */
    private function getFileDocument(File $file)
    {
        return new FileDocument($file);
    }

}
