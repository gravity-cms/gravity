<?php

namespace Gravity\Component\Theme\Templating\Locator;

use Gravity\Component\Theme\ThemeInterface;
use Gravity\Component\Theme\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\Config\FileLocatorInterface;

class ThemeLocator implements FileLocatorInterface
{
    /**
     * @var ThemeManager
     */
    protected $themeManager;

    /**
     * @param ThemeManager $themeManager
     */
    function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    /**
     * Returns a full path for a given file name.
     *
     * @param mixed  $name        The file name to locate
     * @param string $currentPath The current path
     * @param bool   $first       Whether to return the first occurrence or an array of filenames
     *
     * @return string|array The full path to the file|An array of file paths
     *
     * @throws \InvalidArgumentException When file is not found
     */
    public function locate($name, $currentPath = null, $first = true)
    {
        if($name instanceof TemplateReference)
        {
            $name = $name->getPath();
        }

        if(strpos($name, '@theme_') === 0 && preg_match('/@theme_([^\/]+)(.+)/', $name, $matches))
        {
            list($fullPath, $themeName, $path) = $matches;
            $theme = $this->themeManager->getTheme($themeName);
            if($theme instanceof ThemeInterface)
            {
                $meta = new \ReflectionClass($theme);
                $file = dirname($meta->getFileName()).$path;
                return $file;
            }
        }

        return false;
    }

} 
