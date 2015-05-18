<?php

namespace Gravity\Component\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Gravity\Component\Form\AutoComplete\AutoCompleteHandlerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class AutoCompleteTransformer implements DataTransformerInterface
{
    /**
     * Auto complete Handler
     *
     * @var AutoCompleteHandlerInterface
     */
    private $handler;

    /**
     * Allow new data objects
     *
     * @var bool
     */
    protected $allowNew;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @param AutoCompleteHandlerInterface $handler
     * @param array                        $options
     * @param boolean                      $allowNew
     */
    public function __construct(AutoCompleteHandlerInterface $handler, array $options, $allowNew)
    {
        $this->handler  = $handler;
        $this->allowNew = $allowNew;
        $this->options  = $options;
    }

    /**
     * Transforms the Document's value to a value for the form field
     */
    public function transform($tags)
    {
        if (!$tags) {
            $tags = array(); // default value
        }

        $tagNames = array();
        foreach ($tags as $tag) {
            $tagNames[] = $tag->{"get".$this->handler->getDataProperty()}();
        }

        return implode(',', $tagNames); // concatenate the tag names to one string
    }

    /**
     * Transforms the value the users has typed to a value that suits the field in the Document
     */
    public function reverseTransform($tags)
    {
        $tagEntities = new ArrayCollection();

        if (!$tags) {
            return $tagEntities;
        }

        $parsedTags = array_filter(array_map('trim', explode(',', $tags)));

        $objects = $this->handler->getObjects($parsedTags, $this->options);

        return $objects;
    }
}
