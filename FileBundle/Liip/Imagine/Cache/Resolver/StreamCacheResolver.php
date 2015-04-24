<?php


namespace Gravity\FileBundle\Liip\Imagine\Cache\Resolver;

use GaufretteExtras\ResolvableFilesystem;
use Knp\Bundle\GaufretteBundle\FilesystemMap;
use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Exception\Imagine\Cache\Resolver\NotResolvableException;
use Liip\ImagineBundle\Imagine\Cache\Resolver\ResolverInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\RequestContext;

/**
 * Class StreamCacheResolver
 *
 * @package Gravity\FileBundle\Liip\Imagine\Cache\Resolver
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class StreamCacheResolver implements ResolverInterface
{


    /**
     * @var RequestContext
     */
    protected $requestContext;

    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var string
     */
    protected $cachePrefix;

    /**
     * @var string
     */
    protected $cacheRoot;

    /**
     * @var FilesystemMap
     */
    protected $filesystemMap;

    /**
     * @var ResolvableFilesystem
     */
    protected $filesystem;

    public function __construct(
        Filesystem $filesystem,
        RequestContext $requestContext,
        FilesystemMap $filesystemMap,
        $scheme,
        $cachePrefix = 'media/cache'
    ) {

        $this->filesystem     = $filesystem;
        $this->requestContext = $requestContext;
        $this->scheme         = $scheme;
        $this->cachePrefix    = trim($cachePrefix, '/');
        $this->cacheRoot      = $this->scheme . $this->cachePrefix;
        $this->filesystemMap  = $filesystemMap;


        $schemeName       = str_replace('://', '', $this->scheme);
        $this->filesystem = $filesystemMap->get($schemeName);
    }

    /**
     * {@inheritDoc}
     */
    public function isStored($path, $filter)
    {
        return $this->filesystem->has($this->getFilePath($path, $filter));
    }

    /**
     * {@inheritDoc}
     */
    public function store(BinaryInterface $binary, $path, $filter)
    {
        $this->filesystem->write(
            $this->getFilePath($path, $filter),
            $binary->getContent()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function remove(array $paths, array $filters)
    {
        if (empty($paths) && empty($filters)) {
            return;
        }

        if (empty($paths)) {
            $filtersCacheDir = [];
            foreach ($filters as $filter) {
                $filtersCacheDir[] = $this->cacheRoot . '/' . $filter;
            }

            $this->filesystem->delete($filtersCacheDir);

            return;
        }

        foreach ($paths as $path) {
            foreach ($filters as $filter) {
                $this->filesystem->delete($this->getFilePath($path, $filter));
            }
        }
    }

    /**
     * Resolves filtered path for rendering in the browser.
     *
     * @param string $path   The path where the original file is expected to be.
     * @param string $filter The name of the imagine filter in effect.
     *
     * @return string The absolute URL of the cached image.
     *
     * @throws NotResolvableException
     */
    public function resolve($path, $filter)
    {
        return $this->filesystem->resolve(
            $this->getFilePath($path, $filter)
        );
    }


    /**
     * {@inheritDoc}
     */
    protected function getFilePath($path, $filter)
    {
        return $this->getFileUrl($path, $filter);
    }

    /**
     * {@inheritDoc}
     */
    protected function getFileUrl($path, $filter)
    {
        // crude way of sanitizing URL scheme ("protocol") part
        $path = str_replace('://', '---', $path);

        return $this->cachePrefix . '/' . $filter . '/' . ltrim($path, '/');
    }


    /**
     * @return string
     */
    protected function getBaseUrl()
    {
        $port = '';
        if ('https' == $this->requestContext->getScheme() && $this->requestContext->getHttpsPort() != 443) {
            $port = ":{$this->requestContext->getHttpsPort()}";
        }

        if ('http' == $this->requestContext->getScheme() && $this->requestContext->getHttpPort() != 80) {
            $port = ":{$this->requestContext->getHttpPort()}";
        }

        $baseUrl = $this->requestContext->getBaseUrl();
        if ('.php' == substr($this->requestContext->getBaseUrl(), -4)) {
            $baseUrl = pathinfo($this->requestContext->getBaseurl(), PATHINFO_DIRNAME);
        }
        $baseUrl = rtrim($baseUrl, '/\\');

        return sprintf(
            '%s://%s%s%s',
            $this->requestContext->getScheme(),
            $this->requestContext->getHost(),
            $port,
            $baseUrl
        );
    }
}
