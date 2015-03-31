<?php

namespace Gravity\FileBundle\File;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\File\Exception\FileFileDeniedException;
use Gravity\FileBundle\File\Exception\FileFileNotFoundException;
use Gravity\FileBundle\File\Optimiser\OptimiseProfileInterface;
use Gravity\FileBundle\File\Resizer\ImageResize;
use Gravity\FileBundle\Model\FileVersion;
use Symfony\Component\HttpFoundation\File\File as HttpFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Local storage file provider. This provider will store all images on the local disk.
 *
 * Class LocalStorageFileProvider
 *
 * @package Gravity\FileBundle\File
 */
class LocalStorageFileProvider extends AbstractFileProvider implements FileProviderInterface
{
    /**
     * @var string
     */
    protected $id = 'local_storeage';

    /**
     * @var string
     */
    protected $form = 'linestorm_cms_form_file';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var UserInterface|null
     */
    protected $user;

    /**
     * @var OptimiseProfileInterface
     */
    protected $optimiser;

    /**
     * Mime types that are accepted
     *
     * @var array
     */
    private $accept = array(
        'image/jpeg' => array('jpg', 'jpeg'),
        'image/png'  => array('png'),
        'image/gif'  => array('gif'),
    );

    /**
     * Where the files are stored in the web folder
     *
     * @var string
     */
    private $storeDirectory;

    /**
     * This is the local path to the web folder
     *
     * @var string
     */
    private $storePath;

    /**
     * @param EntityManager                     $em         The Entity Manager to use
     * @param string                            $fileClass The Entity class
     * @param SecurityContext                   $secutiryContext
     * @param string                            $path
     * @param string                            $src
     */
    function __construct(EntityManager $em, $fileClass, SecurityContext $secutiryContext, $path, $src)
    {
        $this->em                        = $em;
        $this->class                     = $fileClass;
        $this->storePath                 = realpath($path) . DIRECTORY_SEPARATOR;
        $this->storeDirectory            = $src;

        $token = $secutiryContext->getToken();
        if($token)
        {
            $this->user = $token->getUser();
        }
    }

    /**
     * Set the entity manager
     *
     * @param EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * Return the entity class FQNS
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->class;
    }

    /**
     * Return the categoryentity class FQNS
     *
     * @return string
     */
    public function getCategoryEntityClass()
    {
        return $this->class . "Category";
    }

    /**
     * Return the version entity class FQNS
     *
     * @return string
     */
    public function getVersionEntityClass()
    {
        return $this->class . "Version";
    }

    /**
     * @return string
     */
    public function getStorePath()
    {
        return $this->storePath;
    }

    /**
     * @return string
     */
    public function getStoreDirectory()
    {
        return $this->storeDirectory;
    }



    /**
     * @param OptimiseProfileInterface $optimiser
     */
    public function setOptimiser(OptimiseProfileInterface $optimiser)
    {
        $this->optimiser = $optimiser;
    }

    /**
     * @return OptimiseProfileInterface
     */
    public function getOptimiser()
    {
        return $this->optimiser;
    }



    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByHash($hash)
    {
        return $this->em->getRepository($this->class)->findOneBy(array('hash' => $hash));
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $order = array(), $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository($this->class);

        return $repo->findBy($criteria, $order, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function search($query)
    {
        return $this->searchProvider->search($query, Query::HYDRATE_ARRAY);
    }

    /**
     * {@inheritdoc}
     */
    public function store(File $file)
    {
        if(!file_exists($file->getPath()))
        {
            throw new FileFileNotFoundException($file->getPath());
        }

        if(!$file->getUploader() && $this->user instanceof UserInterface)
        {
            $file->setUploader($this->user);
        }

        $this->em->persist($file);
        $this->em->flush($file);

        return $file;
    }

    /**
     * Upload a file, storing it in the temporary
     *
     * @param HttpFile  $httpFile
     * @param File $file
     *
     * @throws Exception\FileFileDeniedException
     * @return File
     */
    public function upload(HttpFile $httpFile, File $file = null)
    {
        if(!$file instanceof File)
        {
            $file = new $this->class();
        }

        if($httpFile instanceof UploadedFile)
        {
            $extension = $httpFile->getClientOriginalExtension();
            $oldName   = $httpFile->getClientOriginalName();
        }
        else
        {
            $extension = $httpFile->getExtension();
            $oldName   = $httpFile->getFilename();
        }

        $httpFileMime = $httpFile->getMimeType();
        if(array_key_exists($httpFileMime, $this->accept) && in_array(strtolower($extension), $this->accept[$httpFileMime]))
        {
            $newFileName = null;

            // if the file name is set, use it over a hashed one
            if($file->getFilename())
            {
                if($file->getPath() != $httpFile->getPathname()) // if it's already in place, we don't need to move it!
                {
                    $newFileName = $file->getFilename();
                }
            }
            else
            {
                $newFileName = md5(time() . rand()) . "." . $extension;
            }

            if($newFileName)
            {
                $httpFile = $httpFile->move($this->storePath, $newFileName);
                $file->setFilename($newFileName);
            }
        }
        else
        {
            throw new FileFileDeniedException($httpFileMime);
        }

        if($file instanceof File)
        {

            $file->setUrl($this->storeDirectory . $httpFile->getFilename());
            $file->setPath($this->storePath . $httpFile->getFilename());
            $file->setSize($httpFile->getSize());
            $file->setStatus(0);
        }

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function update(File $file)
    {
        // index the file object
        $this->searchProvider->index($file);

        $this->em->persist($file);
        $this->em->flush($file);

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(File $file)
    {
        $file = $file->getPath();
        if($file->getSrc() && file_exists($file) && is_file($file))
        {
            unlink($file);
        }

        $this->em->remove($file);
        $this->em->flush();
    }

    public function validateUpload(UploadedFile $file, array $types)
    {
        $mimeType = $file->getClientMimeType();
        foreach($types as $type)
        {
            if(strpos($type, '*') !== false){
                $regex = str_replace('\*', '(.+)', preg_quote($type, '/'));
                if(preg_match("#{$regex}#", $mimeType))
                {
                    return true;
                }
            } else {
                if ($type === $mimeType) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Resize a file object to one or many profiles
     *
     * @param File $file
     * @param array $profiles
     *
     * @return File[]
     */
    public function resize(File $file, array $profiles = array())
    {
        if(!count($profiles))
        {
            $profiles = $this->fileResizeProfileManager->getProfiles();
        }


        $resizedImages = array();
        foreach($profiles as $profile)
        {
            if(is_string($profile))
            {
                $profile = $this->fileResizeProfileManager->getProfile($profile);
            }

            if($profile instanceof FileResizeProfile)
            {
                $resizedImages[] = $this->resizeImage($file, $profile);
            }
        }

        return $resizedImages;
    }


    /**
     * Resize a file object to a set size, returns the persisted file version object
     *
     * @param File              $file
     * @param FileResizeProfile $resizeProfile
     *
     * @return FileVersion
     */
    protected function resizeImage(File $file, FileResizeProfile $resizeProfile)
    {
        $imagePath = pathinfo($file->getPath());
        $imageSize = getimagesize($file->getPath());

        // clear old versions
        $repo = $this->em->getRepository($this->getVersionEntityClass());
        $query = $repo->createQueryBuilder('mv')
            ->delete()
            ->where('mv.file = :file')
            ->andWhere('mv.resizeProfile = :profile')
            ->setParameters(array(
                'file' => $file,
                'profile' => $resizeProfile,
            ))
            ->getQuery();
        $query->execute();

        $image = new ImageResize($file->getPath());

        $resizeMethod = ($imageSize[0] >= $imageSize[1])? ImageResize::RESIZE_MAX_WIDTH : ImageResize::RESIZE_MAX_HEIGHT ;
        $image->resizeTo($resizeProfile->getWidth(), $resizeProfile->getHeight(), $resizeMethod);

        $newWidth  = $image->getResizeWidth();
        $newHeight = $image->getResizeHeight();

        $filename         = "{$imagePath['filename']}_{$newWidth}_x_{$newHeight}.{$imagePath['extension']}";
        $resizedImagePath = "{$imagePath['dirname']}" . DIRECTORY_SEPARATOR . "{$filename}";

        $image->saveImage($resizedImagePath);

        if(file_exists($resizedImagePath))
        {
            $class = $this->getVersionEntityClass();

            /** @var FileVersion $fileVersion */
            $fileVersion = new $class();
            $fileVersion->setFile($file);
            $fileVersion->setResizeProfile($resizeProfile);
            $fileVersion->setPath($resizedImagePath);
            $fileVersion->setSrc($this->storeDirectory . $filename);

            $this->optimiser->optimise($fileVersion);

            $this->em->persist($fileVersion);
            $this->em->flush($fileVersion);

            return $fileVersion;
        }

    }

} 
