<?php


namespace Gravity\FileBundle\Image\Serializer;

use Gravity\FileBundle\Entity\File;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Filter\FilterConfiguration;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

/**
 * Class ImageStyleSerializerEventSubscriber
 *
 * @package Gravity\FileBundle\Image\Serializer
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ImageStyleSerializerEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var FilterConfiguration
     */
    protected $filterConfiguration;

    /**
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @param FilterConfiguration $filterConfiguration
     * @param CacheManager        $cacheManager
     */
    function __construct(FilterConfiguration $filterConfiguration, CacheManager $cacheManager)
    {
        $this->filterConfiguration = $filterConfiguration;
        $this->cacheManager        = $cacheManager;
    }

    /**
     * Returns the events to which this class has subscribed.
     *
     * Return format:
     *     array(
     *         array('event' => 'the-event-name', 'method' => 'onEventName', 'class' => 'some-class', 'format' => 'json'),
     *         array(...),
     *     )
     *
     * The class may be omitted if the class wants to subscribe to events of all classes.
     * Same goes for the format key.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event'  => Events::POST_SERIALIZE,
                'method' => 'createImageStyleLinks'
            ]
        ];
    }

    public function createImageStyleLinks(ObjectEvent $event)
    {
        $file = $event->getObject();

        if($file instanceof File) {
            $guesser = MimeTypeGuesser::getInstance();
            $scheme = $file->getSchemeFilename();
            if(strpos($guesser->guess($scheme), 'image/') === 0) {
                $visitor = $event->getVisitor();

                $styles = [];
                foreach ($this->filterConfiguration->all() as $name => $filter) {
                    $styles[$name] = $this->cacheManager->getBrowserPath($file->getPath(), $name);
                }
                $visitor->addData(
                    'styles',
                    $styles
                );
            }
        }
    }
}
