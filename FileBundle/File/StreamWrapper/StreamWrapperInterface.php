<?php

namespace Gravity\FileBundle\File\StreamWrapper;

interface StreamWrapperInterface
{
    /**
     * @return StreamWrapperInterface
     */
    static function create();

    /**
     * Get the stream scheme name
     *
     * @return string
     */
    public function getScheme();

    /**
     * Gravity StreamWrapper Name
     *
     * @return string
     */
    public function getName();

    /**
     * Gravity StreamWrapper Description
     *
     * @return string
     */
    public function getDescription();

    public function getExternalUrl();

    public function setUri($path);

    public function getUri();

    /**
     * @return string
     */
    public function realpath();

    /**
     * @return bool
     */
    public function dir_closedir();

    /**
     * @param string $path
     * @param int    $options
     *
     * @return bool
     */
    public function dir_opendir($path, $options);

    /**
     * @return string
     */
    public function dir_readdir();

    /**
     * @return bool
     */
    public function dir_rewinddir();

    /**
     * @param string $path
     * @param int    $mode
     * @param int    $options
     *
     * @return bool
     */
    public function mkdir($path, $mode, $options);

    /**
     * @param string $path_from
     * @param string $path_to
     *
     * @return bool
     */
    public function rename($path_from, $path_to);

    /**
     * @param string $path
     * @param int    $options
     *
     * @return bool
     */
    public function rmdir($path, $options);

    /**
     * @param int $cast_as
     *
     * @return resource
     */
    public function stream_cast($cast_as);

    /**
     */
    public function stream_close();

    /**
     * Enter description here...
     *
     * @return bool
     */
    public function stream_eof();

    /**
     * @return bool
     */
    public function stream_flush();

    /**
     * @param mode $operation
     *
     * @return bool
     */
    public function stream_lock($operation);

    /**
     * Enter description here...
     *
     * @param string $path
     * @param string $mode
     * @param int    $options
     * @param string &$opened_path
     *
     * @return bool
     */
    public function stream_open($path, $mode, $options, &$opened_path);

    /**
     * @param int $count
     *
     * @return string
     */
    public function stream_read($count);

    /**
     * @param int $offset
     * @param int $whence = SEEK_SET
     *
     * @return bool
     */
    public function stream_seek($offset, $whence = SEEK_SET);

    /**
     * @param int $option
     * @param int $arg1
     * @param int $arg2
     *
     * @return bool
     */
    public function stream_set_option($option, $arg1, $arg2);

    /**
     * Enter description here...
     *
     * @return array
     */
    public function stream_stat();

    /**
     * @return int
     */
    public function stream_tell();

    /**
     * @param string $data
     *
     * @return int
     */
    public function stream_write($data);

    /**
     * @param string $path
     *
     * @return bool
     */
    public function unlink($path);

    /**
     * @param string $path
     * @param int    $flags
     *
     * @return array
     */
    public function url_stat($path, $flags);
}
