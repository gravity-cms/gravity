<?php

namespace Gravity\TagBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Gravity\TagBundle\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagChoiceType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    function __construct($em)
    {
        $this->em = $em;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /** @var Tag[] $options */
        $options = $this->em->getRepository('GravityTagBundle:Tag')->findAllRootTags();

        $entityOptions = $this->getChildTags($options);

        $resolver
            ->setDefaults([
                'class'    => 'Gravity\TagBundle\Entity\Tag',
                'root_tag' => null,
                //'choices' => $entityOptions,
                'property' => 'name',
            ]);
    }

    /**
     * @param Tag[] $tags
     * @param int   $delta
     *
     * @return array
     */
    protected function getChildTags($tags, $delta = 0)
    {
        $tagOptions = [];
        foreach ($tags as $childTag) {

            $tagOptions[]   = $childTag;
            $childChildTags = $this->getChildTags($childTag->getChildTags(), $delta + 1);
            foreach ($childChildTags as $id => $value) {
                $tagOptions[] = $value;
            }
        }

        return $tagOptions;
    }

    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'tag_choice';
    }
}
