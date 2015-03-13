<?php

namespace Gravity\TagBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Gravity\TagBundle\Entity\Tag;

/**
 * Class TagRepository
 *
 * @package Gravity\TagBundle\Entity\Repository
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllRootTags()
    {
        $query = $this->createQueryBuilder('q')
            ->select('q')
            ->where('q.parentTag IS NULL');

        return $query->getQuery()->getResult();
    }

    /**
     * @param Tag $tag
     * @return array
     */
    public function findAllParentTags(Tag $tag)
    {
        $parents      = [];
        $parentEntity = $tag->getParentTag();
        $hasParents   = true;
        while ($hasParents) {
            if ($parentEntity instanceof Tag) {
                $parents[]    = $parentEntity;
                $parentEntity = $parentEntity->getParentTag();
            } else {
                $hasParents = false;
            }
        }

        return array_reverse($parents);
    }

    public function findAllCategories()
    {
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->where('size(t.childTags) = 0')
            ->orderBy('t.name', 'ASC');

        return $query->getQuery()->getResult();
    }

    public function findAllChildTags(Tag $tag)
    {
        return $this->getChildTags($tag->getChildTags());
    }

    /**
     * @param Tag[] $tags
     * @return array
     */
    protected function getChildTags($tags)
    {
        $tagOptions = [];
        foreach($tags as $childTag)
        {
            $tagOptions[] = $childTag;
            $tagOptions = array_merge($tagOptions, $this->getChildTags($childTag->getChildTags()));
        }

        return $tagOptions;
    }

} 
