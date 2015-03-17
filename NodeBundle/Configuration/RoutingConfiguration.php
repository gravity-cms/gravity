<?php

namespace Gravity\NodeBundle\Configuration;

use Symfony\Component\Validator\Constraints as Assert;
use GravityCMS\Component\Configuration\AbstractConfiguration;
use Gravity\NodeBundle\Form\RoutingConfigurationForm;

/**
 * Class RoutingConfiguration
 *
 * @package Gravity\NodeBundle\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class RoutingConfiguration extends AbstractConfiguration
{
    const CASE_LOWER = 0;
    const CASE_UPPER = 1;
    const CASE_ORIGINAL = 2;

    /**
     * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      minMessage = "The separator must be {{ limit }} character long",
     *      maxMessage = "The separator must be {{ limit }} character long"
     * )
     *
     * @var string
     */
    protected $separator = '-';

    /**
     * @var int
     */
    protected $casing = CASE_LOWER;

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 255,
     *      minMessage = "Must be greater than {{ limit }}",
     *      maxMessage = "Must be less than {{ limit }}"
     * )
     *
     * @var int
     */
    protected $maxLength = 100;

    protected $removePunctuation = true;

    /**
     * Get the name of the config
     *
     * @return string
     */
    public function getType()
    {
        return 'routing.settings';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new RoutingConfigurationForm();
    }

    /**
     * @return int
     */
    public function getCasing()
    {
        return $this->casing;
    }

    /**
     * @param int $casing
     */
    public function setCasing($casing)
    {
        $this->casing = $casing;
    }

    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @param int $maxLength
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;
    }

    /**
     * @return boolean
     */
    public function getRemovePunctuation()
    {
        return $this->removePunctuation;
    }

    /**
     * @return boolean
     */
    public function shouldRemovePunctuation()
    {
        return $this->removePunctuation;
    }

    /**
     * @param boolean $removePunctuation
     */
    public function setRemovePunctuation($removePunctuation)
    {
        $this->removePunctuation = $removePunctuation;
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param string $separator
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    public function processString($term){

        $term = str_replace(' ', $this->getSeparator(), $term);
        if($this->getMaxLength() > strlen($term)){
            $term = substr($term, 0, $this->getMaxLength());
        }
        switch($this->getCasing()){
            case self::CASE_LOWER:
                $term = strtolower($term);
                break;
            case self::CASE_UPPER:
                $term = strtoupper($term);
                break;
        }
        if($this->shouldRemovePunctuation()){
            $term = preg_replace('/[^a-zA-Z0-9-]/', '', $term);
        }

        // remove consecutive dashes
        $term = preg_replace('/--+/', '-', $term);

        return $term;
    }

} 
