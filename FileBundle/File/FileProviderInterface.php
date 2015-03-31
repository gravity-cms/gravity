<?php

namespace Gravity\FileBundle\File;

use Gravity\FileBundle\Entity\File;
use Symfony\Component\HttpFoundation\File\File as HttpFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface that all file providers must implement
 *
 * Interface FileProviderInterface
 *
 * @package Gravity\FileBundle\File
 */
interface FileProviderInterface
{

    /**
     * Get the storage provider's id
     *
     * @return string
     */
    public function getId();

    /**
     * Get a edit/new Form for the file
     *
     * @return string
     */
    public function getForm();

    /**
     * Get an image from storage
     *
     * @param $id
     *
     * @return File
     */
    public function find($id);

    /**
     * @param array   $criteria
     * @param array   $order
     * @param integer $limit
     * @param integer $offset
     *
     * @return File|null
     */
    public function findBy(array $criteria, array $order = array(), $limit = null, $offset = null);

    /**
     * Find an image by the hash. This can stop duplicate images being uploaded.
     *
     * @param string $hash
     *
     * @return File|null
     */
    public function findByHash($hash);

    /**
     * Store an image in the storeage
     *
     * @param File $file
     *
     * @return File
     */
    public function store(File $file);

    /**
     * Upload a file, return a file object
     * NOTE THAT THE RETURNED MEDIA OBJECT IS NOT PERSISTED
     *
     * @param HttpFile $httpFile
     * @param File     $file
     *
     * @return mixed
     */
    public function upload(HttpFile $httpFile, File $file = null);

    /**
     * Update an image in storage
     *
     * @param File $file
     *
     * @return File
     */
    public function update(File $file);

    /**
     * Delete an image in storage
     *
     * @param File $file
     *
     * @return void
     */
    public function delete(File $file);

    /**
     * Search for file by text
     *
     * @param $query
     *
     * @return mixed
     */
    public function search($query);

    /**
     * @param UploadedFile $file
     * @param array        $types
     *
     * @return mixed
     */
    public function validateUpload(UploadedFile $file, array $types);
} 
