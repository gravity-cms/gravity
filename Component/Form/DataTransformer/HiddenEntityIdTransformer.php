<?php

namespace Gravity\Component\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Gravity\Component\Plugin\Media\Model\Media;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class MediaEntityTransformer
 *
 * @package Gravity\Component\Plugin\Media\Form\DataTransformer
 */
class HiddenEntityIdTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    function __construct(EntityManager $entityManager, $class)
    {
        $this->class         = $class;
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms the Document's value to a value for the form field
     *
     * @param mixed $data
     *
     * @return int|null
     */
    public function transform($data)
    {
        if ($data instanceof $this->class) {
            return $data->getId();
        }

        return null;
    }

    /**
     * Transforms the value the users has typed to a value that suits the field in the Document
     *
     * @param mixed $data
     *
     * @return Media|null
     */
    public function reverseTransform($data)
    {
        if (!is_numeric($data)) {
            return null;
        }

        $entity = $this->entityManager->getRepository($this->class)->find($data);

        if (!$entity instanceof $this->class) {
            return null;
        }

        return $entity;
    }
}
