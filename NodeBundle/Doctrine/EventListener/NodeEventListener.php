<?php

namespace Gravity\NodeBundle\Doctrine\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\UnitOfWork;
use Gedmo\SoftDeleteable\SoftDeleteableListener;
use Gravity\CoreBundle\Entity\Route;
use Gravity\NodeBundle\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route as SymfonyRoute;

/**
 * Class NodeEventListener
 *
 * @package Gravity\NodeBundle\Doctrine\EventListener
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeEventListener implements EventSubscriber
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return array(
//            Events::onFlush,
//            Events::prePersist,
//            Events::postRemove,
        );
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        // update any routes
        $this->updateRouting($em, $uow);

        // update edit dates
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Node) {
                $user = $this->container->get('security.context')->getToken()->getUser();
                $entity->setEditedBy($user);
                $entity->setEditedOn(new \DateTime());
                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($entity)), $entity);
            }
        }
    }


    /**
     * On pre-persist, set the createdBy and CreatedOn fields
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Node) {
            if (!$entity->getCreatedBy()) {
                $user = $this->container->get('security.context')->getToken()->getUser();
                $entity->setCreatedBy($user);
            }

            if (!$entity->getCreatedOn()) {
                $entity->setCreatedOn(new \DateTime());
            }
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em     = $args->getEntityManager();

        if ($entity instanceof Node) {
            $route = $entity->getRoute();

            if (!$route instanceof Route) {
                $oldRoute     = $this->createNewNodeRoute($entity);                     // make a new route
                $deletedRoute = $this->createNewNodeDeletedRoute($oldRoute->getPath()); // 410 the new route
                $route        = $this->createNewNodeRouteEntity($deletedRoute);         // create an entity of the route
                $entity->setRoute($route);
                $em->persist($route);
                $em->flush($route);
            } else {
                $symfonyRoute = $this->createNewNodeDeletedRoute($route->getPath());
                $route->setRoute($symfonyRoute);
                $em->persist($route);
                $em->flush($route);
            }
        }
    }

    public function postSoftDelete(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em     = $args->getEntityManager();
        $uow    = $em->getUnitOfWork();

        if($entity instanceof Node) {
            if ($entity->getDeletedOn() instanceof \DateTime) {
                $route = $entity->getRoute();

                if (!$route instanceof Route) {
                    $oldRoute     = $this->createNewNodeRoute($entity);                     // make a new route
                    $deletedRoute = $this->createNewNodeDeletedRoute($oldRoute->getPath()); // 410 the new route
                    $route        = $this->createNewNodeRouteEntity($deletedRoute);         // create an entity of the route
                    $entity->setRoute($route);
                    $em->persist($route);
                    $uow->computeChangeSet($em->getClassMetadata(get_class($route)), $route);

                    $uow->propertyChanged($entity, 'route', null, $route);
                    $uow->scheduleExtraUpdate($entity, array(
                        'route' => array(null, $route)
                    ));
                } else {
                    $symfonyRoute = $this->createNewNodeDeletedRoute($route->getPath());
                    $route->setRoute($symfonyRoute);
                    $em->persist($route);
                    $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($route)), $route);
                }

                $em->persist($entity);
                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($entity)), $entity);
            }
        }

    }

    /**
     * Schedule updates for routing
     *
     * @param EntityManager $em
     * @param UnitOfWork    $uow
     */
    protected function updateRouting(EntityManager $em, UnitOfWork $uow)
    {
        // 302 old routes to the new 200
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Node) {
                $changeSet = $uow->getEntityChangeSet($entity);

                $currentRoute = $entity->getRoute();

                // Check if we have a route. If not, create on and continue
                if (!$currentRoute instanceof Route) {
                    // create the new route
                    $symfonyRoute = $this->createNewNodeRoute($entity);
                    $currentRoute = $this->createNewNodeRouteEntity($symfonyRoute);
                    $entity->setRoute($currentRoute);
                    $em->persist($currentRoute);
                    $uow->computeChangeSet($em->getClassMetadata(get_class($currentRoute)), $currentRoute);
                    $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($entity)), $entity);
                }

                $oldRoute = $currentRoute->getRoute();
                $newRoute = $this->createNewNodeRoute($entity);

                // if the route changed, update it
                if ($newRoute->getPath() !== $oldRoute->getPath()) {
                    // create the new route entity
                    $newRouteEntity = $this->createNewNodeRouteEntity($newRoute);
                    $entity->setRoute($newRouteEntity);
                    $em->persist($newRouteEntity);
                    $uow->computeChangeSet($em->getClassMetadata(get_class($newRouteEntity)), $newRouteEntity);

                    // set any old route to redirtect to the new route
                    $newSymfonyRoute = $this->createNewNodeRedirectRoute($oldRoute->getPath(), $newRoute->getPath());
                    $currentRoute->setRoute($newSymfonyRoute);
                    $em->persist($currentRoute);
                    $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($currentRoute)),
                        $currentRoute);
                }

                if (isset($changeSet['deletedOn'])) {
                    if ($changeSet['deletedOn'] instanceof \DateTime) {
                        // delete
                        $newRoute = $this->createNewNodeDeletedRoute($entity->getPath());
                        $currentRoute->getRoute($newRoute);
                        $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($currentRoute)),
                            $currentRoute);
                    } else {
                        // un-delete
                        $newRoute = $this->createNewNodeRoute($entity);
                        $currentRoute->getRoute($newRoute);
                        $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($currentRoute)),
                            $currentRoute);
                    }
                }

                $em->persist($entity);
                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($entity)), $entity);
            }
        }

        // create 200 routes for new nodes
        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof Node) {
                $symfonyRoute = $this->createNewNodeRoute($entity);
                $route        = $this->createNewNodeRouteEntity($symfonyRoute);
                $em->persist($route);
                $uow->computeChangeSet($em->getClassMetadata(get_class($route)), $route);

                $entity->setRoute($route);
                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($entity)), $entity);
            }
        }
    }

    /**
     * Create a 200 route for a new Node
     *
     * @param Node $node
     *
     * @return SymfonyRoute
     */
    protected function createNewNodeRoute(Node $node)
    {
        $routeManager = $this->container->get('gravity_node.node_route_manager');
        $contentType  = $node->getContentType();
        $pathFormat   = trim($contentType->getPathFormat(), '/');

        $parts = explode('/', $pathFormat);
        foreach ($parts as &$part) {
            if (preg_match('/\[([\w\d-]+):([\w\d-]+)\]/', $part, $matches)) {
                list(, $type, $field) = $matches;
                $part = $routeManager->process($node, $type, $field);
            }
        }
        $newPath = '/' . implode('/', $parts);

        return new SymfonyRoute($newPath, array(
            '_controller' => '\Gravity\NodeBundle\Controller\NodeController::viewAction',
            'node' => $node->getId(),
        ));
    }

    /**
     * Create a redirect route
     *
     * @param $oldPath
     * @param $newPath
     *
     * @return SymfonyRoute
     */
    protected function createNewNodeRedirectRoute($oldPath, $newPath)
    {
        $newSymfonyRoute = new SymfonyRoute($oldPath);
        $newSymfonyRoute->setDefaults(array(
            '_controller' => 'FrameworkBundle:Redirect:urlRedirect',
            'path' => $newPath,
            'permanent' => true,
        ));

        return $newSymfonyRoute;
    }

    /**
     * Creat a 410 route
     *
     * @param $path
     *
     * @return SymfonyRoute
     */
    protected function createNewNodeDeletedRoute($path)
    {
        return $this->createNewNodeRedirectRoute($path, '');
    }

    /**
     * Create a new Route entity for the given route
     *
     * @param SymfonyRoute $route
     *
     * @return Route
     */
    protected function createNewNodeRouteEntity(SymfonyRoute $route)
    {
        $newPathName = str_replace(array('/', '-'), '_', ltrim($route->getPath(), '/'));

        $newRoute = new Route();
        $newRoute->setName('gravity_node_' . $newPathName);
        $newRoute->setPattern($route->getPath());
        $newRoute->setPath($route->getPath());
        $newRoute->setRoute($route);

        return $newRoute;
    }

} 
