<?php

namespace Gravity\FileBundle\File;

use Doctrine\Common\Persistence\ObjectManager;
use Gravity\FileBundle\Configuration\FileConfiguration;
use Gravity\FileBundle\Entity\File;
use Gravity\FileBundle\File\Exception\FileUploadException;
use Gravity\FileBundle\File\Exception\FileUploadExtensionDeniedException;
use Gravity\FileBundle\File\Exception\FileUploadFailedException;
use Gravity\FileBundle\File\StreamWrapper\StreamWrapperInterface;
use Gravity\FileBundle\File\StreamWrapper\StreamWrapperManager;
use GravityCMS\Component\Configuration\ConfigurationManager;
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
     * @var StreamWrapperManager
     */
    protected $streamWrapperManager;

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

    function __construct(
        ConfigurationManager $configurationManager,
        ObjectManager $objectManager,
        StreamWrapperManager $streamWrapperManager
    ) {
        $this->streamWrapperManager = $streamWrapperManager;
        $this->configurationManager = $configurationManager;
        $this->config               = $configurationManager->get('file:settings');
        $this->objectManager        = $objectManager;
    }

    /**
     * @return FileConfiguration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return StreamWrapperInterface
     */
    public function getDefaultStreamWrapper()
    {
        return $this->streamWrapperManager->getStreamWrapper(
            $this->config->getDefaultStreamWrapperScheme()
        );
    }

    /**
     * @param $path
     *
     * @return StreamWrapperInterface
     */
    public function createStreamForPath($path)
    {
        return $this->streamWrapperManager->createStreamForPath($path);
    }

    /**
     * Search the file providers for
     *
     * @param string $id       Image identifier
     * @param string $provider Provider Identifier
     *
     * @return null
     */
    public function find($id, $provider = null)
    {
        if ($provider && array_key_exists($provider, $this->fileProviders)) {
            return $this->fileProviders[$provider]->find($id);
        } else {
            $provider = $this->getDefaultProviderInstance();

            return $provider->find($id);
        }
    }

    /**
     * Search the file providers for
     *
     * @param array  $terms
     * @param string $provider Provider Identifier
     *
     * @internal param string $id Image identifier
     * @return null
     */
    public function findBy(array $terms, $provider = null)
    {
        if ($provider && array_key_exists($provider, $this->fileProviders)) {
            return $this->fileProviders[$provider]->findBy($terms);
        } else {
            $provider = $this->getDefaultProviderInstance();

            return $provider->findBy($terms);
        }
    }

    /**
     * Search for file by text
     *
     * @param string $query
     * @param null   $provider
     *
     * @return mixed
     */
    public function search($query, $provider = null)
    {
        if ($provider && array_key_exists($provider, $this->fileProviders)) {
            return $this->fileProviders[$provider]->searchBy($query);
        } else {
            $provider = $this->getDefaultProviderInstance();

            return $provider->search($query);
        }
    }


    /**
     * Store the file into the bank
     *
     * @param File   $file
     * @param string $provider
     *
     * @return File
     */
    public function store(File $file, $provider = null)
    {
        if ($provider && array_key_exists($provider, $this->fileProviders)) {
            return $this->fileProviders[$provider]->store($file);
        } else {
            return $this->fileProviders[$this->defaultProvider]->store($file);
        }
    }

    /**
     * Update a file model
     *
     * @param File $file
     * @param null $provider
     *
     * @return File
     */
    public function update(File $file, $provider = null)
    {
        if ($provider && array_key_exists($provider, $this->fileProviders)) {
            return $this->fileProviders[$provider]->update($file);
        } else {
            return $this->fileProviders[$this->defaultProvider]->update($file);
        }
    }


    /**
     * Delete a file model
     *
     * @param File $file
     * @param null $provider
     *
     * @return File
     */
    public function delete(File $file, $provider = null)
    {
        if ($provider && array_key_exists($provider, $this->fileProviders)) {
            $this->fileProviders[$provider]->delete($file);
        } else {
            $this->fileProviders[$this->defaultProvider]->delete($file);
        }
    }


    /**
     * Handle a file upload
     *
     * @param SymfonyFile|UploadedFile $file
     * @param StreamWrapperInterface   $streamWrapper If left null, default stream is used
     *
     * @return File
     * @throws FileUploadException
     * @throws FileUploadFailedException
     */
    public function upload(SymfonyFile $file, StreamWrapperInterface $streamWrapper = null)
    {
        if ($file->isValid()) {
            if (!$streamWrapper instanceof StreamWrapperInterface) {
                $streamWrapper = $this->getDefaultStreamWrapper();
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

                $baseFileName  = str_replace(' ', '_' ,pathinfo($name, PATHINFO_FILENAME));
                $baseFilePath  = $streamWrapper->getScheme() . '://files/';
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

                $file = $file->move($streamWrapper->getScheme() . '://files', $name);
            } else {
                throw new FileUploadExtensionDeniedException();
            }

            if (!($file instanceof SymfonyFile)) {
                throw new FileUploadException('Upload Invalid');
            }

            $fileEntity = new File();
            $fileEntity->setCreatedOn(new \DateTime());
            $fileEntity->setName($file->getFilename());
            $fileEntity->setFilename($file->getFilename());
            $fileEntity->setSize($file->getSize());
            $fileEntity->setPath($file->getPathname());

            $fileStream = $this->createStreamForPath($file->getPathname());
            $fileEntity->setUrl($fileStream->getExternalUrl());

            $this->objectManager->persist($fileEntity);
            $this->objectManager->flush($fileEntity);

            return $fileEntity;
        } else {
            throw new FileUploadFailedException($file->getError());
        }
    }
}
