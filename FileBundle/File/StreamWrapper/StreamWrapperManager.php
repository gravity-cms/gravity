<?php

namespace Gravity\FileBundle\File\StreamWrapper;

/**
 * Class StreamWrapperManager
 *
 * @package Gravity\FileBundle\File\StreamWrapper
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class StreamWrapperManager
{
    /**
     * @var StreamWrapperInterface[]
     */
    protected $streamWrappers = [];

    /**
     * @return StreamWrapperInterface[]
     */
    public function getStreamWrappers()
    {
        return $this->streamWrappers;
    }

    public function getStreamWrapper($scheme)
    {
        return $this->streamWrappers[$scheme];
    }

    /**
     * @param StreamWrapperInterface[] $streamWrappers
     */
    public function setStreamWrappers($streamWrappers)
    {
        foreach ($streamWrappers as $streamWrapper) {
            $this->addStreamWrapper($streamWrapper);
        }
    }

    /**
     * @param StreamWrapperInterface $streamWrapper
     */
    public function addStreamWrapper(StreamWrapperInterface $streamWrapper)
    {
        $this->streamWrappers[$streamWrapper->getScheme()] = $streamWrapper;
        stream_wrapper_register($streamWrapper->getScheme(), get_class($streamWrapper));
    }

    /**
     * @param string $path
     *
     * @return StreamWrapperInterface
     */
    public function createStreamForPath($path)
    {
        list($scheme,) = explode('://', $path);

        if($scheme && isset($this->streamWrappers[$scheme])){
            $streamWrapper = $this->streamWrappers[$scheme];
            $stream = $streamWrapper::create();
            $stream->setUri($path);
            return $stream;
        }
    }
}
