<?php

require 'vendor/autoload.php';
require __DIR__.'/app/AppKernel.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


//Creating "Request" object from php global variables
$request = Request::createFromGlobals();

$kernel = new AppKernel('dev', true);
$response = $kernel->handle($request, HttpKernelInterface::MASTER_REQUEST, true);

//Send the response to the end client
$response->send();

//Call terminate method
$kernel->terminate($request, $response);