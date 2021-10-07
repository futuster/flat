<?php

require_once '../src/models.php';
require_once '../src/controllers.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('/index.php' === $uri || '/' === $uri) {
    list_post_action();
}

if ('/show/' === $uri && isset($_GET['id'])) {
    show_post_action($_GET['id']);
}

if('/create/' === $uri) {
    create_post_action();
}

header('HTTP/1.1 404 Not Found');
echo '<html><body><h1>Page Not Found</h1></body></html>';
