<?php

require_once '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$uri = $request->getPathInfo();

if ('/' === $uri) {
    $response = list_post_action();
} elseif ('/show/' === $uri && $request->query->has('id')) {
    $response = show_post_action($request->query->get('id'));
} elseif ('/create/' === $uri) {
    $response = create_post_action();
} else {
    $html = '<html lang="en"><body><h1>Page Not Found</h1></body></html>';
    $response = new Response($html, Response::HTTP_NOT_FOUND);
}

// echo the headers and send the response
$response->send();
