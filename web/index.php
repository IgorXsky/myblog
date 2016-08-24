<?php

ini_set('display_errors', '1');
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// Autoload
$loader = require __DIR__.'/../app/autoload.php';
Debug::enable();

// Framework init
$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();

// Handle request
$response = $kernel->handle($request);

// send response
$response->send();
$kernel->terminate($request, $response);
