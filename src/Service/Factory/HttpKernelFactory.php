<?php

namespace HttpKernel\Formation\Service\Factory;

use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class HttpKernelFactory
 *
 * @package HttpKernel\Formation\Service\Factory
 */
class HttpKernelFactory
{
    /**
     * Creates an instance of HttpKernel class
     *
     * @return HttpKernel
     */
    public function getHttpKernel()
    {
        //Creating "UrlMatcher" object
        $urlMatcher = new UrlMatcher($this->registerRoutes(), new RequestContext());
        //Creating "EventDispatcher" object
        $eventDispatcher = new EventDispatcher();

        $eventDispatcher->addSubscriber(new RouterListener($urlMatcher, new RequestStack()));

        $controllerResolver = new ControllerResolver();
        $argumentResolver   = new ArgumentResolver();

        return new HttpKernel($eventDispatcher, $controllerResolver, new RequestStack(), $argumentResolver);
    }

    /**
     * @return RouteCollection
     */
    private function registerRoutes()
    {
        $routes = new RouteCollection();
        /*$routes->add('hello', new Route('/hello/{name}',
            [
                '_controller' => function (Request $request) {
                    return new Response(
                        sprintf("Hello %s", $request->get('name'))
                    );
                }
            ]
        ));*/

        $routes->add('hello', new Route('/hello/{name}',
            [
                '_controller' => 'HttpKernel\Formation\Controller\CustomController::helloAction'
            ]
        ));

        return $routes;
    }
}