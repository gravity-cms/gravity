<?php

namespace Gravity\Component\Theme\Twig\Loader;

use Gravity\Component\Theme\ThemeManager;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;

class ThemeLoader extends FilesystemLoader
{
    /**
     * @var ThemeManager
     */
    private $themeManager;

    /**
     * @param ThemeManager                $themeManager
     * @param FileLocatorInterface        $locator
     * @param TemplateNameParserInterface $parser
     */
    function __construct(ThemeManager $themeManager, FileLocatorInterface $locator, TemplateNameParserInterface $parser)
    {
        $this->themeManager = $themeManager;

        parent::__construct($locator, $parser);
    }

    /**
     * {@inheritdoc}
     */
    protected function findTemplate($template)
    {
        $templateName = (string) $template;

        // Only try and load templates which aren't namespaced
        if (strpos($templateName, '@theme/') === 0) {

            $templatePath = str_replace('@theme', '', $templateName);
            $theme = $this->themeManager->getAdminTheme();

            return parent::findTemplate('@theme_'.$theme->getName().$templatePath);
        }

        if (strpos($templateName, 'theme_') === 0) {
            if(preg_match('/theme_([^:]+):([^:]*):(.*)/', $templateName, $matches))
            {
                list($fullName, $themeName, $path, $file) = $matches;

                $theme = $this->themeManager->getTheme($themeName);

                return parent::findTemplate('@theme_'.$theme->getName().$path.'/'.$file);
            }
        }

        return parent::findTemplate($template);
    }


} 
