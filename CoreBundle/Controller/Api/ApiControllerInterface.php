<?php

namespace Gravity\CoreBundle\Controller\Api;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;

/**
 * Interface ApiControllerInterface
 *
 * @package Gravity\CoreBundle\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @deprecated use ApiEntityServiceControllerTrait instead
 */
interface ApiControllerInterface
{
    /** @var string */
    const METHOD_GET = 'GET';
    /** @var int */
    const METHOD_PATCH = 'PATCH';
    /** @var int */
    const METHOD_POST = 'POST';
    /** @var int */
    const METHOD_PUT = 'PUT';
    /** @var int */
    const METHOD_DELETE = 'DELETE';

    /**
     * Get the form type
     *
     * @return AbstractType
     */
    function getForm();

    /**
     * Get the template for the form
     *
     * @param $method
     *
     * @return string
     */
    function getFormTemplate($method);

    /**
     * Lookup the method and build a URL
     *
     * @param int   $method
     * @param mixed $entity
     *
     * @return mixed
     */
    function getUrl($method, $entity = null);

    function hasPermission($method);
} 
