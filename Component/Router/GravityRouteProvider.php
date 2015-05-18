<?php

namespace Gravity\Component\Router;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Gravity\CoreBundle\Entity\Repository\RouteRepository;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class GravityRouteProvider implements RouteProviderInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var RouteRepository
     */
    private $routeRepository;

    function __construct(EntityManager $entityManager)
    {
        $this->entityManager   = $entityManager;
        $this->routeRepository = $entityManager->getRepository('GravityCoreBundle:Route');
    }

    /**
     * Finds routes that may potentially match the request.
     *
     * This may return a mixed list of class instances, but all routes returned
     * must extend the core symfony route. The classes may also implement
     * RouteObjectInterface to link to a content document.
     *
     * This method may not throw an exception based on implementation specific
     * restrictions on the url. That case is considered a not found - returning
     * an empty array. Exceptions are only used to abort the whole request in
     * case something is seriously broken, like the storage backend being down.
     *
     * Note that implementations may not implement an optimal matching
     * algorithm, simply a reasonable first pass.  That allows for potentially
     * very large route sets to be filtered down to likely candidates, which
     * may then be filtered in memory more completely.
     *
     * @param Request $request A request against which to match.
     *
     * @return RouteCollection with all Routes that could potentially match
     *                         $request. Empty collection if nothing can match.
     */
    public function getRouteCollectionForRequest(Request $request)
    {
        $path  = $request->getPathInfo();
        $parts = array_values(array_filter(explode('/', $path), function ($value) {
            return $value !== null && $value !== '';
        }));

        $collection = new RouteCollection();

        $ancestors = $this->getCandidateOutlines($parts);

        /** @var \Gravity\CoreBundle\Model\Route[] $routes */
        $routes = $this->routeRepository->createQueryBuilder('r')
            ->select('r')
            ->where('r.pattern IN (:ancestors)')
            ->setParameter('ancestors', $ancestors)
            ->getQuery()
            ->getResult();

        foreach ($routes as $route) {
            $collection->add($route->getName(), $route->getRoute());
        }

        return $collection;
    }

    /**
     * Find the route using the provided route name.
     *
     * @param string $name The route name to fetch.
     *
     * @return Route
     *
     * @throws RouteNotFoundException If there is no route with that name in
     *                                this repository
     */
    public function getRouteByName($name)
    {
        try {
            $route = $this->routeRepository->findOneBy(array(
                'name' => $name
            ));
            if (!$route) {
                throw new RouteNotFoundException();
            }

        }
        catch (NoResultException $e) {
            throw new RouteNotFoundException();
        }

        return $route->getRoute();
    }

    /**
     * Find many routes by their names using the provided list of names.
     *
     * Note that this method may not throw an exception if some of the routes
     * are not found or are not actually Route instances. It will just return the
     * list of those Route instances it found.
     *
     * This method exists in order to allow performance optimizations. The
     * simple implementation could be to just repeatedly call
     * $this->getRouteByName() while catching and ignoring eventual exceptions.
     *
     * If $names is null, this method SHOULD return a collection of all routes
     * known to this provider. If there are many routes to be expected, usage of
     * a lazy loading collection is recommended. A provider MAY only return a
     * subset of routes to e.g. support paging or other concepts, but be aware
     * that the DynamicRouter will only call this method once per
     * DynamicRouter::getRouteCollection() call.
     *
     * @param array|null $names The list of names to retrieve, In case of null,
     *                          the provider will determine what routes to return.
     *
     * @return Route[] Iterable list with the keys being the names from the
     *                     $names array.
     */
    public function getRoutesByNames($names)
    {

        /** @var \Gravity\CoreBundle\Model\Route[] $routes */
        $routes = $this->routeRepository->findBy(array(
            'name' => $names,
        ));

        return $routes;
    }


    /**
     * Returns an array of path pattern outlines that could match the path parts.
     *
     * @param array $parts
     *   The parts of the path for which we want candidates.
     *
     * @return array
     *   An array of outlines that could match the specified path parts.
     */
    public function getCandidateOutlines(array $parts)
    {
        $number_parts = count($parts);
        $ancestors    = array();
        $length       = $number_parts - 1;
        $end          = (1 << $number_parts) - 1;

        // The highest possible mask is a 1 bit for every part of the path. We will
        // check every value down from there to generate a possible outline.
        if ($number_parts == 1) {
            $masks = array(1);
        } elseif ($number_parts > 1) {
            // Optimization - don't query the state system for short paths. This also
            // insulates against the state entry for masks going missing for common
            // user-facing paths since we generate all values without checking state.
            $masks = range($end, 1);
        } elseif ($number_parts <= 0) {
            // No path can match, short-circuit the process.
            $masks = array();
        }


        // Only examine patterns that actually exist as router items (the masks).
        foreach ($masks as $i) {
            if ($i > $end) {
                // Only look at masks that are not longer than the path of interest.
                continue;
            } elseif ($i < (1 << $length)) {
                // We have exhausted the masks of a given length, so decrease the length.
                --$length;
            }
            $current = '';
            for ($j = $length; $j >= 0; $j--) {
                // Check the bit on the $j offset.
                if ($i & (1 << $j)) {
                    // Bit one means the original value.
                    $current .= $parts[$length - $j];
                } else {
                    // Bit zero means means wildcard.
                    $current .= '%';
                }
                // Unless we are at offset 0, add a slash.
                if ($j) {
                    $current .= '/';
                }
            }
            $ancestors[] = '/' . $current;
        }

        return $ancestors;
    }

}
