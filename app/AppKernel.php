<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
    /**
     * @inheritdoc
     */
    public function registerBundles()
    {
        return [];
    }

    /** @inheritdoc */
    public function build(ContainerBuilder $container)
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

        //Creating "UrlMatcher" object
        $urlMatcher = new UrlMatcher($routes, new RequestContext());
        //Creating "EventDispatcher" object
        $eventDispatcher = new EventDispatcher();

        $eventDispatcher->addSubscriber(new RouterListener($urlMatcher, new RequestStack()));

        $container->register('event_dispatcher')
                  ->setSynthetic(true);
        $container->set('event_dispatcher', $eventDispatcher);

        $container->register('controller_resolver','Symfony\Component\HttpKernel\Controller\ControllerResolver');
        $container->register('argument_resolver', 'Symfony\Component\HttpKernel\Controller\ArgumentResolver');
        $container->register('request_stack', 'Symfony\Component\HttpFoundation\RequestStack');

        $container->register('http_kernel', 'Symfony\Component\HttpKernel\HttpKernel')
                  ->addArgument()
                  ->addArgument(new Reference('controller_resolver'))
                  ->addArgument(new Reference('request_stack'))
                  ->addArgument(new Reference('argument_resolver'));
    }

    /**
     * @inheritdoc
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/../Config/parameters.yml');
    }
}