<?php declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

if ($request->getMethod() === 'POST') {
    $parsed = $request->getParsedBody();

    if (isset($parsed['_method'])) {
        $request = $request->withMethod(strtoupper($parsed['_method']));    
    }
}

require __DIR__ . '/../config/routes.php';

$response = $router->dispatch($request);

(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
