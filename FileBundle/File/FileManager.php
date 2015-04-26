<?php

namespace Gravity\FileBundle\File;

use Doctrine\Common\Persistence\ObjectManager;
use GaufretteExtras\ResolvableFilesystem;
use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\File\Exception\FileUploadException;
use Gravity\FileBundle\File\Exception\FileUploadExtensionDeniedException;
use Gravity\FileBundle\File\Exception\FileUploadFailedException;
use GravityCMS\Component\Configuration\ConfigurationManager;
use Knp\Bundle\GaufretteBundle\FilesystemMap;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileManager
 *
 * @package Gravity\FileBundle\File
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileManager
{
    /**
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ResolvableFilesystem
     */
    protected $fileSystem;

    /**
     * @var string
     */
    protected $defaultFilesystem;

    /**
     * @var array
     */
    protected $allowedFileExtensions;

    /**
     * @param string        $defaultFilesystem
     * @param ObjectManager $objectManager
     * @param FilesystemMap $filesystemMap
     */
    function __construct(
        $defaultFilesystem,
        ObjectManager $objectManager,
        FilesystemMap $filesystemMap
    ) {
        $this->defaultFilesystem = $defaultFilesystem;
        $this->objectManager     = $objectManager;
        $this->fileSystem        = $filesystemMap->get($defaultFilesystem);
    }

    /**
     * @return array
     */
    public function getAllowedFileExtensions()
    {
        return $this->allowedFileExtensions;
    }

    /**
     * @param array $allowedFileExtensions
     */
    public function setAllowedFileExtensions(array $allowedFileExtensions)
    {
        $this->allowedFileExtensions = $allowedFileExtensions;
    }

    /**
     * @return ResolvableFilesystem
     */
    public function getFileSystem()
    {
        return $this->fileSystem;
    }

    public function getScheme()
    {
        return 'gravity://' . $this->defaultFilesystem . '/';
    }

    /**
     * Handle a file upload
     *
     * @param SymfonyFile|UploadedFile $file
     *
     * @return File
     * @throws FileUploadException
     * @throws FileUploadFailedException
     */
    public function upload(SymfonyFile $file)
    {
        if ($file->isValid()) {

            if ($file instanceof UploadedFile) {
                $extension = $file->getClientOriginalExtension();
                $name      = $file->getClientOriginalName();
            } else {
                $extension = $file->getExtension();
                $name      = $file->getFilename();
            }

            $fileMime          = $file->getMimeType();
            $allowedExtensions = $this->getConfig()->getAllowedExtensions();
            if (in_array(strtolower($extension), $allowedExtensions)) {
                $baseFileName  = str_replace(' ', '_', pathinfo($name, PATHINFO_FILENAME));
                $baseFilePath  = $this->getScheme();
                $baseExtension = '.' . $extension;
                if (file_exists($baseFilePath . $baseFileName . $baseExtension)) {
                    $exists = true;
                    $count  = 1;
                    while ($exists) {
                        $tryFileName = $baseFileName . '-' . $count . $baseExtension;
                        $tryFilePath = $baseFilePath . $tryFileName;
                        if (!file_exists($tryFilePath)) {
                            $name = $tryFileName;
                            break;
                        }
                        ++$count;
                    }
                }

                $this->fileSystem->write(
                    $name,
                    file_get_contents($file->getPathname())
                );

                $newFile = $this->fileSystem->get($name);
            } else {
                throw new FileUploadExtensionDeniedException();
            }

            if (!($newFile instanceof \Gaufrette\File)) {
                throw new FileUploadException('Upload Invalid');
            }

            $fileEntity = new File();
            $fileEntity->setCreatedOn(new \DateTime());
            $fileEntity->setName($newFile->getName());
            $fileEntity->setFilename($newFile->getName());
            $fileEntity->setSize($newFile->getSize());
            $fileEntity->setPath('/' . $newFile->getKey());
            $fileEntity->setFilesystem($this->config->getDefaultFilesystem());
            $fileEntity->setUrl($this->fileSystem->resolve($newFile->getName()));

            $this->objectManager->persist($fileEntity);
            $this->objectManager->flush($fileEntity);

            return $fileEntity;
        } else {
            throw new FileUploadFailedException($file->getError());
        }
    }
}
