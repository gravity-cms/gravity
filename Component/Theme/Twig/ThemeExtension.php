<?php

namespace Gravity\Component\Theme\Twig;

use Gravity\Component\Theme\ThemeManager;

class ThemeExtension extends \Twig_Extension
{
    /**
     * @var ThemeManager
     */
    private $themeManager;

    /**
     * @param ThemeManager $themeManager
     */
    function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('gravity_theme_admin', array($this, 'getAdminTheme')),
        );
    }

    /**
     * Get the admin theme namespace
     */
    public function getAdminTheme()
    {
        $this->themeManager->getAdminTheme();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'gravity_theme';
    }

} 
