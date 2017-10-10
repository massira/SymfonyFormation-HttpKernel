<?php

require 'vendor/autoload.php';

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\HttpKernel;

//Create routes collection
$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}',
    [
        '_controller' => function (Request $request) {
            return new Response(
                sprintf("Hello %s", $request->get('name'))
            );
        }
    ]
));

//Creating "Request" object from php global variables
$request = Request::createFromGlobals();

//Creating "UrlMatcher" object
$urlMatcher = new UrlMatcher($routes, new RequestContext());

//Creating "EventDispatcher" object
$eventDispatcher = new EventDispatcher();

$eventDispatcher->addSubscriber(new RouterListener($urlMatcher, new RequestStack()));

//ControllerResolver and ArgumentResolver objects
$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

//Creating httpKernel object
$httpKernel = new HttpKernel($eventDispatcher, $controllerResolver, new RequestStack(), $argumentResolver);
//Handles the request
$response = $httpKernel->handle($request);

//Send the response to the end client
$response->send();

//Call terminate method
$httpKernel->terminate($request, $response);