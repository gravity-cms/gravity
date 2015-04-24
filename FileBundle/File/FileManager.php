<?php

namespace Gravity\FileBundle\File;

use Doctrine\Common\Persistence\ObjectManager;
use Gaufrette\Filesystem;
use GaufretteExtras\ResolvableFilesystem;
use Gravity\FileBundle\Configuration\FileConfiguration;
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
     * @var FileConfiguration
     */
    protected $config;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ResolvableFilesystem
     */
    protected $fileSystem;

    function __construct(
        ConfigurationManager $configurationManager,
        ObjectManager $objectManager,
        FilesystemMap $filesystemMap
    ) {
        $this->configurationManager = $configurationManager;
        $this->config               = $configurationManager->get('file:settings');
        $this->objectManager        = $objectManager;
        $this->fileSystem           = $filesystemMap->get($this->config->getDefaultFilesystem());
    }

    /**
     * @return FileConfiguration
     */
    public function getConfig()
    {
        return $this->config;
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
        return 'gravity://' . $this->config->getDefaultFilesystem() . '/';
    }

    /**
     * Handle a file upload
     *
     * @param SymfonyFile|UploadedFile $file
     * @param Filesystem               $filesystem If left null, default filesystem is used
     *
     * @return File
     * @throws FileUploadException
     * @throws FileUploadFailedException
     */
    public function upload(SymfonyFile $file, Filesystem $filesystem = null)
    {
        if ($file->isValid()) {
            if (!$filesystem instanceof Filesystem) {
                $filesystem = $this->fileSystem;
            }

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

                $filesystem->write(
                    $name,
                    file_get_contents($file->getPathname())
                );

                $newFile = $filesystem->get($name);
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
            $fileEntity->setPath($this->getScheme() . $newFile->getKey());
            $fileEntity->setUrl($filesystem->resolve($newFile->getName()));

            $this->objectManager->persist($fileEntity);
            $this->objectManager->flush($fileEntity);

            return $fileEntity;
        } else {
            throw new FileUploadFailedException($file->getError());
        }
    }
}
